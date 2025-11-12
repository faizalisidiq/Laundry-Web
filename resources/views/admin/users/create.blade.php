@extends('layouts.app')

@section('title', 'Tambah User - Laundry System')
@section('page-title', 'Tambah User')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Form Tambah User</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('users.store') }}" method="POST">
          @csrf

          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name') }}"
                   required>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="email" class="form-label fw-bold">Email <span class="text-danger">*</span></label>
            <input type="email" 
                   class="form-control @error('email') is-invalid @enderror" 
                   id="email" 
                   name="email" 
                   value="{{ old('email') }}"
                   required>
            @error('email')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="phone" class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('phone') is-invalid @enderror" 
                   id="phone" 
                   name="phone" 
                   value="{{ old('phone') }}"
                   required>
            @error('phone')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="role_id" class="form-label fw-bold">Role <span class="text-danger">*</span></label>
            <select name="role_id" id="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
              <option value="">-- Pilih Role --</option>
              @foreach($roles as $role)
              <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                {{ $role->display_name }}
              </option>
              @endforeach
            </select>
            @error('role_id')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password" class="form-label fw-bold">Password <span class="text-danger">*</span></label>
            <input type="password" 
                   class="form-control @error('password') is-invalid @enderror" 
                   id="password" 
                   name="password" 
                   required>
            <small class="text-muted">Minimal 6 karakter</small>
            @error('password')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-bold">Konfirmasi Password <span class="text-danger">*</span></label>
            <input type="password" 
                   class="form-control" 
                   id="password_confirmation" 
                   name="password_confirmation" 
                   required>
          </div>

          <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save me-2"></i>Simpan
            </button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
              <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection