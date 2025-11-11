@extends('layouts.app')

@section('title', 'Edit Role - Laundry System')
@section('page-title', 'Edit Role')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Form Edit Role</h5>
      </div>
      <div class="card-body">
        <form action="{{ route('roles.update', $role->id) }}" method="POST">
          @csrf
          @method('PUT')

          <div class="mb-3">
            <label for="name" class="form-label fw-bold">Nama Role <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('name') is-invalid @enderror" 
                   id="name" 
                   name="name" 
                   value="{{ old('name', $role->name) }}"
                   required>
            <small class="text-muted">Gunakan huruf kecil tanpa spasi (contoh: kasir, manager)</small>
            @error('name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="display_name" class="form-label fw-bold">Nama Tampilan <span class="text-danger">*</span></label>
            <input type="text" 
                   class="form-control @error('display_name') is-invalid @enderror" 
                   id="display_name" 
                   name="display_name" 
                   value="{{ old('display_name', $role->display_name) }}"
                   required>
            <small class="text-muted">Nama yang akan ditampilkan di aplikasi</small>
            @error('display_name')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="mb-3">
            <label for="description" class="form-label fw-bold">Deskripsi</label>
            <textarea class="form-control @error('description') is-invalid @enderror" 
                      id="description" 
                      name="description" 
                      rows="3">{{ old('description', $role->description) }}</textarea>
            @error('description')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>

          <div class="d-flex gap-2 mt-4">
            <button type="submit" class="btn btn-primary">
              <i class="bi bi-save me-2"></i>Update
            </button>
            <a href="{{ route('roles.index') }}" class="btn btn-secondary">
              <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection