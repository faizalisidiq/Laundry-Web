@extends('layouts.app')

@section('title', 'Kelola Role - Laundry System')
@section('page-title', 'Kelola Role')

@section('content')
<!-- Alert Messages -->
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
  <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<!-- Header & Button -->
<div class="d-flex justify-content-between align-items-center mb-4">
  <h4 class="fw-bold mb-0">Daftar Role</h4>
  <a href="{{ route('roles.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle me-2"></i>Tambah Role
  </a>
</div>

<!-- Table -->
<div class="card border-0 shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th width="5%">No</th>
            <th width="15%">Nama Role</th>
            <th width="20%">Nama Tampilan</th>
            <th width="35%">Deskripsi</th>
            <th width="10%" class="text-center">Jumlah User</th>
            <th width="15%" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($roles as $index => $role)
          <tr>
            <td>{{ $roles->firstItem() + $index }}</td>
            <td><span class="badge bg-primary">{{ $role->name }}</span></td>
            <td class="fw-bold">{{ $role->display_name }}</td>
            <td>{{ $role->description ?? '-' }}</td>
            <td class="text-center">
              <span class="badge bg-info">{{ $role->users_count }}</span>
            </td>
            <td class="text-center">
              <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('roles.show', $role->id) }}" 
                   class="btn btn-info" title="Detail">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('roles.edit', $role->id) }}" 
                   class="btn btn-warning" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                @if($role->users_count == 0)
                <form action="{{ route('roles.destroy', $role->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus role ini?')"
                      class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
                @else
                <button class="btn btn-danger" disabled title="Role masih digunakan">
                  <i class="bi bi-trash"></i>
                </button>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="text-center text-muted py-4">
              <i class="bi bi-inbox display-4 d-block mb-2"></i>
              Belum ada role
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
      {{ $roles->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>
@endsection