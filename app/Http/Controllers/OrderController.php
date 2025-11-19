<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Layanan;
use App\Models\Od;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with('user', 'od.layanan')->latest();

        // Filter berdasarkan status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('resi', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Sorting berdasarkan tanggal pemesanan
        $sortBy = $request->input('sort_by', 'tanggal_pemesanan');
        $sortOrder = $request->input('sort_order', 'desc');

        // Validasi input sorting
        if (!in_array($sortBy, ['tanggal_pemesanan'])) {
            $sortBy = 'tanggal_pemesanan';
        }

        if (!in_array($sortOrder, ['asc', 'desc'])) {
            $sortOrder = 'desc';
        }

        $query->orderBy($sortBy, $sortOrder);

        // ✅ Pagination dengan mempertahankan parameter filter
        $perPage = $request->input('per_page', 10);
        $orders = $query->paginate($perPage)->appends($request->except('page'));

        return view('admin.pesanan.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $layanans = Layanan::all();
        return view('admin.pesanan.create', compact('layanans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'tanggal_pemesanan' => 'required|date',
            'layanan_id' => 'required|array|min:1',
            'layanan_id.*' => 'required|exists:layanans,id',
            'berat' => 'required|array|min:1',
            'berat.*' => 'required|numeric|min:0.1',
            'paid_amount' => 'nullable|numeric|min:0',
        ], [
            'customer_name.required' => 'Nama pelanggan wajib diisi',
            'phone.required' => 'Nomor telepon wajib diisi',
            'tanggal_pemesanan.required' => 'Tanggal pemesanan wajib diisi',
            'layanan_id.required' => 'Pilih minimal 1 layanan',
            'berat.*.required' => 'Berat wajib diisi',
            'berat.*.min' => 'Berat minimal 0.1 kg',
        ]);

        DB::beginTransaction();

        try {
            do {
                // Generate angka acak 4 digit (0001–9999)
                $resi = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);
            } while (Order::where('resi', $resi)->exists());


            // Hitung total harga dan tanggal selesai
            $totalHarga = 0;
            $maxDurasi = 0;

            foreach ($request->layanan_id as $index => $layananId) {
                $layanan = Layanan::find($layananId);
                $berat = $request->berat[$index];
                $subtotal = $layanan->harga * $berat;
                $totalHarga += $subtotal;

                if ($layanan->durasi_hari > $maxDurasi) {
                    $maxDurasi = $layanan->durasi_hari;
                }
            }

            $tanggalSelesai = date('Y-m-d H:i:s', strtotime($request->tanggal_pemesanan . " +{$maxDurasi} days"));

            // Hitung payment status
            $paidAmount = $request->paid_amount ?? 0;
            $paymentStatus = $paidAmount >= $totalHarga ? 'Lunas' : 'Belum Lunas';

            // Simpan order
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'status' => 'Menunggu',
                'resi' => $resi,
                'total_harga' => $totalHarga,
                'tanggal_pemesanan' => $request->tanggal_pemesanan,
                'tanggal_selesai' => $tanggalSelesai,
                'payment_status' => $paymentStatus,
                'paid_amount' => $paidAmount,
                'wa_sent' => false,
            ]);

            // Simpan order details
            foreach ($request->layanan_id as $index => $layananId) {
                $layanan = Layanan::find($layananId);
                $berat = $request->berat[$index];
                $harga = $layanan->harga;
                $subtotal = $harga * $berat;

                Od::create([
                    'order_id' => $order->id,
                    'layanan_id' => $layananId,
                    'berat' => $berat,
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();

            return redirect()->route('pesanan.index')
                ->with('success', 'Pesanan berhasil ditambahkan dengan resi: ' . $resi);
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $pesanan)
    {
        $pesanan->load('user', 'od.layanan');
        return view('admin.pesanan.show', compact('pesanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $pesanan)
    {
        $pesanan->load('od.layanan');
        $layanans = Layanan::all();
        return view('admin.pesanan.edit', compact('pesanan', 'layanans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $pesanan)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:100',
            'phone' => 'required|string|max:20',
            'status' => 'required|in:Menunggu,Diproses,Selesai,Diambil',
            'tanggal_pemesanan' => 'required|date',
            'layanan_id' => 'required|array|min:1',
            'layanan_id.*' => 'required|exists:layanans,id',
            'berat' => 'required|array|min:1',
            'berat.*' => 'required|numeric|min:0.1',
            'paid_amount' => 'nullable|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Hitung ulang total harga dan tanggal selesai
            $totalHarga = 0;
            $maxDurasi = 0;

            foreach ($request->layanan_id as $index => $layananId) {
                $layanan = Layanan::find($layananId);
                $berat = $request->berat[$index];
                $subtotal = $layanan->harga * $berat;
                $totalHarga += $subtotal;

                if ($layanan->durasi_hari > $maxDurasi) {
                    $maxDurasi = $layanan->durasi_hari;
                }
            }

            $tanggalSelesai = date('Y-m-d H:i:s', strtotime($request->tanggal_pemesanan . " +{$maxDurasi} days"));

            // Hitung payment status
            $paidAmount = $request->paid_amount ?? $pesanan->paid_amount;
            $paymentStatus = $paidAmount >= $totalHarga ? 'Lunas' : 'Belum Lunas';

            // Update order
            $pesanan->update([
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'status' => $request->status,
                'total_harga' => $totalHarga,
                'tanggal_pemesanan' => $request->tanggal_pemesanan,
                'tanggal_selesai' => $tanggalSelesai,
                'payment_status' => $paymentStatus,
                'paid_amount' => $paidAmount,
            ]);

            // Hapus order details lama
            $pesanan->od()->delete();

            // Simpan order details baru
            foreach ($request->layanan_id as $index => $layananId) {
                $layanan = Layanan::find($layananId);
                $berat = $request->berat[$index];
                $harga = $layanan->harga;
                $subtotal = $harga * $berat;

                Od::create([
                    'order_id' => $pesanan->id,
                    'layanan_id' => $layananId,
                    'berat' => $berat,
                    'harga' => $harga,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();

            return redirect()->route('pesanan.index')
                ->with('success', 'Pesanan berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $pesanan)
    {
        try {
            $pesanan->delete();
            return redirect()->route('pesanan.index')
                ->with('success', 'Pesanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('pesanan.index')
                ->with('error', 'Terjadi kesalahan saat menghapus pesanan!');
        }
    }

    /**
     * Update status pesanan (Quick Update)
     */
    public function updateStatus(Request $request, Order $pesanan)
    {
        $validated = $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Selesai,Diambil',
        ]);

        $pesanan->update([
            'status' => $request->status,
        ]);

        return redirect()->back()
            ->with('success', 'Status pesanan berhasil diperbarui menjadi ' . $request->status . '!');
    }

    /**
     * Kirim WhatsApp
     */
  /**
 * Kirim WhatsApp - DUAL MESSAGE (Awal & Selesai)
 */
public function sendWhatsApp(Order $pesanan)
{
    try {
        $pesanan->load('od.layanan');

        // Format nomor telepon
        $phone = preg_replace('/[^0-9]/', '', $pesanan->phone);
        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        }
        if (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        // Tentukan jenis pesan berdasarkan status
        if (in_array($pesanan->status, ['Selesai', 'Diambil'])) {
            // PESAN SELESAI
            $message = $this->generateCompletionMessage($pesanan);
        } else {
            // PESAN AWAL (Menunggu/Diproses)
            $message = $this->generateInitialMessage($pesanan);
        }

        // URL encode message
        $encodedMessage = urlencode($message);

        // Buat link WhatsApp
        $waLink = "https://wa.me/{$phone}?text={$encodedMessage}";

        // Update status WA sent
        $pesanan->update([
            'wa_sent' => true,
            'wa_sent_at' => now(),
        ]);

        // Redirect ke WhatsApp
        return redirect($waLink);
        
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal mengirim WhatsApp: ' . $e->getMessage());
    }
}

/**
 * Generate Pesan Awal (Menunggu/Diproses)
 */
private function generateInitialMessage(Order $pesanan)
{
    // Build detail layanan
    $detailLayanan = "";
    foreach ($pesanan->od as $detail) {
        $detailLayanan .= "▪️ *" . strtoupper($detail->layanan->nama_layanan) . "*\n";
        $detailLayanan .= "   Berat: *{$detail->berat} KG*\n";
        $detailLayanan .= "   Harga: Rp" . number_format($detail->harga, 0, ',', '.') . "/kg\n";
        $detailLayanan .= "   * Subtotal: Rp" . number_format($detail->subtotal, 0, ',', '.') . "*\n\n";
    }

    // Hitung sisa tagihan
    $sisaTagihan = $pesanan->total_harga - $pesanan->paid_amount;
    $statusPembayaran = $pesanan->payment_status;
    
    if ($statusPembayaran === 'Lunas') {
        $statusText = " *𝗟𝗨𝗡𝗔𝗦* ";
    } else {
        $statusText = " *𝗕𝗘𝗟𝗨𝗠 𝗟𝗨𝗡𝗔𝗦* \n";
        $statusText .= " *Sisa Tagihan:*\n";
        $statusText .= "*Rp" . number_format($sisaTagihan, 0, ',', '.') . "*";
    }

    // Build pesan AWAL
    $message = "┏━━━━━━━━━━━━━━━━━━━━━┓\n";
    $message .= "  *𝗕𝗘𝗥𝗟𝗜𝗔𝗡 𝗟𝗔𝗨𝗡𝗗𝗥𝗬*\n";
    $message .= "┗━━━━━━━━━━━━━━━━━━━━━┛\n\n";
    
    $message .= " Jl. R.E. Martadinata, Nabarua\n";
    $message .= "   Nabire, Papua Tengah 98817\n";
    $message .= " *6281343047741*\n\n";
    
    $message .= " *𝗣𝗘𝗦𝗔𝗡𝗔𝗡 𝗗𝗜𝗧𝗘𝗥𝗜𝗠𝗔*\n\n";
    $message .= "Halo *{$pesanan->customer_name}*! \n\n";
    $message .= "Pesanan Anda telah kami terima dan sedang dalam proses pencucian.\n\n";
    
    $message .= " *𝗗𝗘𝗧𝗔𝗜𝗟 𝗣𝗘𝗦𝗔𝗡𝗔𝗡*\n\n";
    $message .= " *RESI: #{$pesanan->resi}*\n";
    $message .= " Nama: {$pesanan->customer_name}\n";
    $message .= " HP: {$pesanan->phone}\n\n";

    $message .= " *Tanggal Terima:*\n";
    $message .= "   " . \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d/m/Y H:i') . " WIT\n\n";
    
    $message .= " *Estimasi Selesai:*\n";
    $message .= "   *" . \Carbon\Carbon::parse($pesanan->tanggal_selesai)->format('d/m/Y H:i') . " WIT*\n\n";
    
    $message .= "*𝗗𝗘𝗧𝗔𝗜𝗟 𝗟𝗔𝗬𝗔𝗡𝗔𝗡*\n\n";
    $message .= $detailLayanan;
    
    $message .= " *𝗧𝗢𝗧𝗔𝗟 𝗧𝗔𝗚𝗜𝗛𝗔𝗡*\n\n";
    $message .= "      *Rp " . number_format($pesanan->total_harga, 0, ',', '.') . "*\n\n";
    
    $message .= " *𝗦𝗧𝗔𝗧𝗨𝗦 𝗣𝗘𝗠𝗕𝗔𝗬𝗔𝗥𝗔𝗡*\n\n";
    $message .= "{$statusText}\n\n";
    
    $message .= " *𝗖𝗘𝗞 𝗦𝗧𝗔𝗧𝗨𝗦 𝗢𝗡𝗟𝗜𝗡𝗘*\n";
    $message .= route('user.tracking') . "\n\n";
    
    $message .= " _Terima kasih atas kepercayaan Anda!_\n";
    $message .= " *Berlian Laundry*\n";
    $message .= " _Pakaian Bersih, Hati Senang!_";

    return $message;
}

/**
 * Generate Pesan Selesai (Ready to Pickup)
 */
private function generateCompletionMessage(Order $pesanan)
{
    // Build detail layanan (ringkas)
    $detailLayanan = "";
    foreach ($pesanan->od as $detail) {
        $detailLayanan .= "▪️ {$detail->layanan->nama_layanan} - {$detail->berat} KG\n";
    }

    // Hitung sisa tagihan
    $sisaTagihan = $pesanan->total_harga - $pesanan->paid_amount;
    $statusPembayaran = $pesanan->payment_status;

    // Build pesan SELESAI
    $message = "┏━━━━━━━━━━━━━━━━━━━━━┓\n";
    $message .= "  *𝗕𝗘𝗥𝗟𝗜𝗔𝗡 𝗟𝗔𝗨𝗡𝗗𝗥𝗬*\n";
    $message .= "┗━━━━━━━━━━━━━━━━━━━━━┛\n\n";
    
    $message .= " *𝗣𝗘𝗦𝗔𝗡𝗔𝗡 𝗦𝗘𝗟𝗘𝗦𝗔𝗜!* \n\n";
    
    $message .= "Halo *{$pesanan->customer_name}*! \n\n";
    
    $message .= " Kabar baik! Cucian Anda sudah *SELESAI* dan siap untuk diambil.\n\n";
    
    $message .= " *𝗜𝗡𝗙𝗢 𝗣𝗘𝗦𝗔𝗡𝗔𝗡*\n\n";
    $message .= " Nomor Resi: *#{$pesanan->resi}*\n";
    $message .= " Nama: {$pesanan->customer_name}\n";
    $message .= " HP: {$pesanan->phone}\n\n";
    
    $message .= " *Layanan:*\n";
    $message .= $detailLayanan . "\n";
    
    $message .= " *𝗧𝗢𝗧𝗔𝗟 𝗧𝗔𝗚𝗜𝗛𝗔𝗡*\n";
    $message .= "*Rp " . number_format($pesanan->total_harga, 0, ',', '.') . "*\n\n";
    
    if ($statusPembayaran === 'Lunas') {
        $message .= " Status: *LUNAS*\n\n";
    } else {
        $message .= " Status: *Belum Lunas*\n";
        $message .= " Sisa Tagihan: *Rp" . number_format($sisaTagihan, 0, ',', '.') . "*\n\n";
        $message .= " _Mohon selesaikan pembayaran saat pengambilan._\n\n";
    }
    
    $message .= " *𝗔𝗟𝗔𝗠𝗔𝗧 𝗣𝗘𝗡𝗚𝗔𝗠𝗕𝗜𝗟𝗔𝗡*\n\n";
    $message .= " Jl. R.E. Martadinata, Nabarua\n";
    $message .= "   Nabire, Papua Tengah 98817\n\n";
    
    $message .= " *Jam Operasional:*\n";
    $message .= "Senin - Sabtu: 08.00 - 20.00 WIT\n";
    $message .= "Minggu: Tutup\n\n";
    
    $message .= " Hubungi: *6281343047741*\n\n";
    
    $message .= " *Info Selengkapnya:*\n";
    $message .= route('user.tracking') . "\n\n";
    
    $message .= " *Terima kasih atas kepercayaan Anda!*\n\n";
    $message .= "Kami tunggu kedatangan Anda untuk mengambil cucian.\n\n";
    $message .= " *Berlian Laundry*\n";
    $message .= " _Pakaian Bersih, Hati Senang!_";

    return $message;
}

    /**
     * Cetak Struk
     */
    public function printStruk(Order $pesanan)
    {
        $pesanan->load('od.layanan');
        return view('admin.pesanan.print', compact('pesanan'));
    }


    /**
     * Export PDF
     */
    public function exportPdf(Request $request)
{
    try {
        // Validasi input
        $request->validate([
            'bulan' => 'required|integer|between:1,12',
            'tahun' => 'required|integer|min:2020',
            'filter_status' => 'required|in:all,selesai',
        ]);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun');
        $filterStatus = $request->input('filter_status', 'selesai');

        // Query builder
        $query = Order::whereMonth('tanggal_pemesanan', $bulan)
            ->whereYear('tanggal_pemesanan', $tahun)
            ->with('od.layanan');

        // Filter berdasarkan pilihan status
        if ($filterStatus === 'selesai') {
            $query->whereIn('status', ['Selesai', 'Diambil'])
                  ->where('payment_status', 'Lunas');
        }

        // Ambil data dan urutkan
        $orders = $query->orderBy('tanggal_pemesanan', 'desc')->get();

        // Jika tidak ada data
        if ($orders->isEmpty()) {
            $namaBulan = \Carbon\Carbon::create($tahun, $bulan)
                ->locale('id')
                ->translatedFormat('F Y');
            
            return redirect()->back()
                ->with('error', "Tidak ada data pesanan untuk periode {$namaBulan}");
        }

        // Nama bulan
        $namaBulan = \Carbon\Carbon::create($tahun, $bulan)
            ->locale('id')
            ->translatedFormat('F Y');

        // Generate PDF (SIMPLIFIED)
        $pdf = Pdf::loadView('admin.pesanan.pdf', [
            'orders' => $orders,
            'namaBulan' => $namaBulan,
            'filterStatus' => $filterStatus,
        ])->setPaper('A4', 'portrait');

        // Filename
        $statusLabel = $filterStatus === 'selesai' ? 'Selesai_Lunas' : 'Semua';
        $filename = 'Rekap_Pesanan_' . $statusLabel . '_' . str_replace(' ', '_', $namaBulan) . '.pdf';
        
        // Download
        return $pdf->download($filename);
        
    } catch (\Exception $e) {
        return redirect()->back()
            ->with('error', 'Gagal mengekspor PDF: ' . $e->getMessage());
    }
}

/**
 * Get customer data for autocomplete
 */
public function getCustomers(Request $request)
{
    $search = $request->get('q', '');
    
    $customers = Order::select('customer_name', 'phone')
        ->when($search, function($query) use ($search) {
            $query->where('customer_name', 'like', "%{$search}%");
        })
        ->groupBy('customer_name', 'phone')
        ->orderBy('customer_name')
        ->limit(10)
        ->get()
        ->map(function($customer) {
            return [
                'id' => $customer->customer_name,
                'text' => $customer->customer_name,
                'phone' => $customer->phone
            ];
        });
    
    return response()->json([
        'results' => $customers
    ]);
}
}