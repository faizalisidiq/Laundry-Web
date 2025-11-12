<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    /**
     * Tampilkan halaman input resi
     */
    public function index()
    {
        return view('user.tracking');
    }

    /**
     * Tampilkan detail tracking berdasarkan resi
     */
public function show($resi)
{
    $order = Order::with(['od.layanan', 'user'])
        ->where('resi', 'LIKE', "%{$resi}")
        ->first();

    if (!$order) {
        return redirect()->route('user.tracking')
            ->with('error', 'Nomor resi tidak ditemukan!');
    }

    return view('user.tracking-detail', compact('order'));
}

    /**
     * Handle form submit tracking (optional, jika pakai POST)
     */
    public function track(Request $request)
    {
        $request->validate([
            'resi' => 'required|digits:4'
        ]);

        return redirect()->route('tracking.show', $request->resi);
    }
}