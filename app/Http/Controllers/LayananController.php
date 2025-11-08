<?php

namespace App\Http\Controllers;

use App\Models\Layanan;
use Illuminate\Http\Request;

class LayananController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $layanans = Layanan::latest()->paginate(10);
        return view('admin.layanan.index', compact('layanans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.layanan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'durasi_hari' => 'required|integer|min:1',
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi',
            'nama_layanan.max' => 'Nama layanan maksimal 100 karakter',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal 0',
            'durasi_hari.required' => 'Durasi hari wajib diisi',
            'durasi_hari.integer' => 'Durasi hari harus berupa angka',
            'durasi_hari.min' => 'Durasi hari minimal 1',
        ]);

        Layanan::create($validated);

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Layanan $layanan)
    {
        return view('admin.layanan.show', compact('layanan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Layanan $layanan)
    {
        return view('admin.layanan.edit', compact('layanan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Layanan $layanan)
    {
        $validated = $request->validate([
            'nama_layanan' => 'required|string|max:100',
            'deskripsi' => 'required|string',
            'harga' => 'required|numeric|min:0',
            'durasi_hari' => 'required|integer|min:1',
        ], [
            'nama_layanan.required' => 'Nama layanan wajib diisi',
            'nama_layanan.max' => 'Nama layanan maksimal 100 karakter',
            'deskripsi.required' => 'Deskripsi wajib diisi',
            'harga.required' => 'Harga wajib diisi',
            'harga.numeric' => 'Harga harus berupa angka',
            'harga.min' => 'Harga minimal 0',
            'durasi_hari.required' => 'Durasi hari wajib diisi',
            'durasi_hari.integer' => 'Durasi hari harus berupa angka',
            'durasi_hari.min' => 'Durasi hari minimal 1',
        ]);

        $layanan->update($validated);

        return redirect()->route('layanan.index')
            ->with('success', 'Layanan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Layanan $layanan)
    {
        try {
            $layanan->delete();
            return redirect()->route('layanan.index')
                ->with('success', 'Layanan berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('layanan.index')
                ->with('error', 'Layanan tidak dapat dihapus karena masih digunakan!');
        }
    }
}