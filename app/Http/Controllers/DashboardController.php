<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Layanan;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalLayanan = Layanan::count();
        $totalPesanan = Order::count();
        $totalPelanggan = Order::distinct('customer_name')->count('customer_name');
        $totalPendapatan = Order::where('status', 'Diambil')->sum('total_harga');

        // Pesanan berdasarkan status
        $pesananMenunggu = Order::where('status', 'Menunggu')->count();
        $pesananDiproses = Order::where('status', 'Diproses')->count();
        $pesananSelesai = Order::where('status', 'Selesai')->count();
        $pesananDiambil = Order::where('status', 'Diambil')->count();

        // Aktivitas terbaru (5 pesanan terakhir)
        $aktivitasTerbaru = Order::with('user')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Pendapatan bulan ini
        $pendapatanBulanIni = Order::where('status', 'Diambil')
            ->whereMonth('tanggal_selesai', date('m'))
            ->whereYear('tanggal_selesai', date('Y'))
            ->sum('total_harga');

        // Layanan terpopuler
        $layananTerpopuler = DB::table('od')
            ->join('layanans', 'od.layanan_id', '=', 'layanans.id')
            ->select('layanans.nama_layanan', DB::raw('COUNT(*) as total'))
            ->groupBy('layanans.nama_layanan')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalLayanan',
            'totalPesanan',
            'totalPelanggan',
            'totalPendapatan',
            'pesananMenunggu',
            'pesananDiproses',
            'pesananSelesai',
            'pesananDiambil',
            'aktivitasTerbaru',
            'pendapatanBulanIni',
            'layananTerpopuler'
        ));
    }
}