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
    public function sendWhatsApp(Order $pesanan)
    {
        try {
            $pesanan->load('od.layanan');

            // Format nomor telepon (hapus +, spasi, strip)
            $phone = preg_replace('/[^0-9]/', '', $pesanan->phone);

            // Jika diawali 0, ganti dengan 62
            if (substr($phone, 0, 1) === '0') {
                $phone = '62' . substr($phone, 1);
            }

            // Jika tidak diawali 62, tambahkan 62
            if (substr($phone, 0, 2) !== '62') {
                $phone = '62' . $phone;
            }

            // Build detail layanan
            $detailLayanan = "";
            foreach ($pesanan->od as $detail) {
                $detailLayanan .= "✔ {$detail->layanan->nama_layanan} - {$detail->berat} KG @ Rp" . number_format($detail->harga, 0, ',', '.') . " → Total Rp" . number_format($detail->subtotal, 0, ',', '.') . "\n";
            }

            // Hitung sisa tagihan
            $sisaTagihan = $pesanan->total_harga - $pesanan->paid_amount;
            $statusPembayaran = $pesanan->payment_status;
            $statusText = $statusPembayaran === 'Lunas'
                ? "Lunas ✅"
                : "Belum Lunas (Sisa Tagihan : Rp" . number_format($sisaTagihan, 0, ',', '.') . ")";

            // Build pesan WhatsApp
            $message = "🧺 *Berlian Laundry*\n";
            $message .= "Jl. R.E. Martadinata, Nabarua, Distrik Nabire, Kabupaten Nabire, Papua Tengah 98817\n";
            $message .= "Telp/WA: 6281343047741\n\n";
            $message .= "*Nomor Pesanan : #{$pesanan->resi}*\n";
            $message .= "Pelanggan : Kak {$pesanan->customer_name}\n";
            $message .= "Terima : " . \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d/m/Y H:i') . "\n";
            $message .= "Estimasi Selesai : " . \Carbon\Carbon::parse($pesanan->tanggal_selesai)->format('d/m/Y H:i') . "\n\n";
            $message .= "📌 *Detail Layanan:*\n";
            $message .= $detailLayanan;
            $message .= "\n💰 *Total Tagihan : Rp" . number_format($pesanan->total_harga, 0, ',', '.') . "*\n";
            $message .= "Status Pembayaran : {$statusText}\n";
            $message .= "===============================\n";
            $message .= "📲 Pantau status cucian Anda di sini:\n";
            $message .= "👉 " . route('user.tracking') . "\n\n";
            $message .= "🙏 Terima kasih sudah menggunakan layanan Berlian Laundry";

            // URL encode message
            $encodedMessage = urlencode($message);

            // Buat link WhatsApp
            $waLink = "https://wa.me/{$phone}?text={$encodedMessage}";

            // Update status WA sent
            $pesanan->update([
                'wa_sent' => true,
                'wa_sent_at' => now(),
            ]);

            // Redirect ke WhatsApp Web/App
            return redirect($waLink);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal mengirim WhatsApp: ' . $e->getMessage());
        }
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
    public function ExportPdf(Request $request)
    {
        $bulan = $request->input('bulan', now()->month);
        $tahun = $request->input('tahun', now()->year);

        $orders = Order::where('status', 'Selesai')
            ->with('od.layanan')
            ->where('payment_status', 'Lunas')
            ->whereMonth('tanggal_pemesanan', $bulan)
            ->whereYear('tanggal_pemesanan', $tahun)
            ->orderBy('tanggal_pemesanan', 'desc')
            ->get();

        $namaBulan = \Carbon\Carbon::create($tahun, $bulan)->locale('id')->translatedFormat('F Y');

        $pdf = Pdf::loadView('admin.pesanan.pdf', compact('orders', 'namaBulan'));

        return $pdf->download('Daftar_Pesanan_' . $namaBulan . '_export_at_' . now()->format('d-m-Y') . '_' . now()->format('H-i-s') . '.pdf');
    }
}
