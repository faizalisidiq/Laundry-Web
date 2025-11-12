<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('users')->latest()->paginate(10);
        return view('admin.roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:roles,name',
            'display_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama role wajib diisi',
            'name.unique' => 'Nama role sudah ada',
            'display_name.required' => 'Nama tampilan wajib diisi',
        ]);

        Role::create($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->loadCount('users');
        $users = $role->users()->paginate(10);
        return view('admin.roles.show', compact('role', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:roles,name,' . $role->id,
            'display_name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Nama role wajib diisi',
            'name.unique' => 'Nama role sudah ada',
            'display_name.required' => 'Nama tampilan wajib diisi',
        ]);

        $role->update($validated);

        return redirect()->route('roles.index')
            ->with('success', 'Role berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Cegah hapus role yang masih digunakan
        if ($role->users()->count() > 0) {
            return redirect()->route('roles.index')
                ->with('error', 'Role tidak dapat dihapus karena masih digunakan oleh user!');
        }

        try {
            $role->delete();
            return redirect()->route('roles.index')
                ->with('success', 'Role berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('roles.index')
                ->with('error', 'Terjadi kesalahan saat menghapus role!');
        }
    }
}