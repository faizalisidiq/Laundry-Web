@extends('layouts.app')

@section('title', 'Detail Role - Laundry System')
@section('page-title', 'Detail Role')

@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Informasi Role</h5>
      </div>
      <div class="card-body">
        <div class="mb-3">
          <label class="text-muted small">Nama Role</label>
          <p class="fw-bold mb-0">
            <span class="badge bg-primary fs-6">{{ $role->name }}</span>
          </p>
        </div>

        <hr>

        <div class="mb-3">
          <label class="text-muted small">Nama Tampilan</label>
          <p class="fw-bold mb-0">{{ $role->display_name }}</p>
        </div>

        <hr>

        <div class="mb-3">
          <label class="text-muted small">Deskripsi</label>
          <p class="mb-0">{{ $role->description ?? '-' }}</p>
        </div>

        <hr>

        <div class="mb-3">
          <label class="text-muted small">Jumlah User</label>
          <p class="fw-bold mb-0">
            <span class="badge bg-info fs-6">{{ $role->users_count }}</span>
          </p>
        </div>

        <hr>

        <div class="mb-3">
          <label class="text-muted small">Dibuat Pada</label>
          <p class="mb-0">{{ $role->created_at->format('d/m/Y H:i') }}</p>
        </div>

        <div class="mb-3">
          <label class="text-muted small">Terakhir Diubah</label>
          <p class="mb-0">{{ $role->updated_at->format('d/m/Y H:i') }}</p>
        </div>
      </div>
    </div>

    <div class="d-flex gap-2 mt-3">
      <a href="{{ route('roles.edit', $role->id) }}" class="btn btn-warning">
        <i class="bi bi-pencil me-2"></i>Edit
      </a>
      <a href="{{ route('roles.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
      </a>
      @if($role->users_count == 0)
      <form action="{{ route('roles.destroy', $role->id) }}" 
            method="POST" 
            onsubmit="return confirm('Yakin ingin menghapus role ini?')"
            class="ms-auto">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">
          <i class="bi bi-trash me-2"></i>Hapus
        </button>
      </form>
      @endif
    </div>
  </div>

  <div class="col-md-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Daftar User dengan Role ini</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>Nama</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Bergabung</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              @forelse($users as $user)
              <tr>
                <td class="fw-bold">{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->phone }}</td>
                <td>{{ $user->created_at->format('d/m/Y') }}</td>
                <td class="text-center">
                  <a href="{{ route('users.show', $user->id) }}" class="btn btn-sm btn-info">
                    <i class="bi bi-eye"></i>
                  </a>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center text-muted">Belum ada user dengan role ini</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-end mt-3">
          {{ $users->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection