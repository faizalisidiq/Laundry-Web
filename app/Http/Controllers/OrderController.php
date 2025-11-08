<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Layanan;
use App\Models\Od;  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            $query->where(function($q) use ($search) {
                $q->where('resi', 'like', "%{$search}%")
                  ->orWhere('customer_name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10);
        
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
            // Generate resi unik
            $resi = 'LDR' . date('Ymd') . str_pad(Order::whereDate('created_at', today())->count() + 1, 4, '0', STR_PAD_LEFT);

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

            // Update order
            $pesanan->update([
                'customer_name' => $request->customer_name,
                'phone' => $request->phone,
                'status' => $request->status,
                'total_harga' => $totalHarga,
                'tanggal_pemesanan' => $request->tanggal_pemesanan,
                'tanggal_selesai' => $tanggalSelesai,
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
     * Update status pesanan
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
            ->with('success', 'Status pesanan berhasil diperbarui!');
    }
}