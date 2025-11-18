@extends('layouts.app')

@section('title', 'Kelola User - Laundry System')
@section('page-title', 'Kelola User')

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
  <h4 class="fw-bold mb-0">Daftar User</h4>
  <a href="{{ route('users.create') }}" class="btn btn-primary">
    <i class="bi bi-plus-circle me-2"></i>Tambah User
  </a>
</div>

<!-- Filter & Search -->
<div class="card border-0 shadow-sm mb-3">
  <div class="card-body">
    <form action="{{ route('users.index') }}" method="GET" class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Role</label>
        <select name="role_id" class="form-select">
          <option value="">Semua Role</option>
          @foreach($roles as $role)
          <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
            {{ $role->display_name }}
          </option>
          @endforeach
        </select>
      </div>
      <div class="col-md-6">
        <label class="form-label">Cari (Nama/Email/Telepon)</label>
        <input type="text" name="search" class="form-control" placeholder="Masukkan kata kunci..." value="{{ request('search') }}">
      </div>
      <div class="col-md-2">
        <label class="form-label">&nbsp;</label>
        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-search me-2"></i>Filter
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Table -->
<div class="card border-0 shadow-sm">
  <div class="card-body">
    <div class="table-responsive">
      <table class="table table-hover align-middle">
        <thead class="table-light">
          <tr>
            <th width="5%">No</th>
            <th width="20%">Nama</th>
            <th width="20%">Email</th>
            <th width="15%">Telepon</th>
            <th width="15%">Role</th>
            <th width="15%">Bergabung</th>
            <th width="10%" class="text-center">Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($users as $index => $user)
          <tr>
            <td>{{ $users->firstItem() + $index }}</td>
            <td class="fw-bold">{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->phone }}</td>
            <td>
              <span class="badge bg-{{ $user->role->name == 'superadmin' ? 'danger' : 'primary' }}">
                {{ $user->role->display_name }}
              </span>
            </td>
            <td>{{ $user->created_at->format('d/m/Y') }}</td>
            <td class="text-center">
              <div class="btn-group btn-group-sm" role="group">
                <a href="{{ route('users.show', $user->id) }}" 
                   class="btn btn-info" title="Detail">
                  <i class="bi bi-eye"></i>
                </a>
                <a href="{{ route('users.edit', $user->id) }}" 
                   class="btn btn-warning" title="Edit">
                  <i class="bi bi-pencil"></i>
                </a>
                @if($user->id !== auth()->id())
                <form action="{{ route('users.destroy', $user->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus user ini?')"
                      class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" title="Hapus">
                    <i class="bi bi-trash"></i>
                  </button>
                </form>
                @endif
              </div>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="text-center text-muted py-4">
              <i class="bi bi-inbox display-4 d-block mb-2"></i>
              Belum ada user
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-end mt-3">
      {{ $users->links('pagination::bootstrap-5') }}
    </div>
  </div>
</div>
@endsection