@extends('layouts.app')

@section('title', 'Detail User - Laundry System')
@section('page-title', 'Detail User')

@section('content')
<div class="row">
  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center">
        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&size=150" 
             class="rounded-circle mb-3" 
             alt="{{ $user->name }}">
        <h5 class="fw-bold">{{ $user->name }}</h5>
        <span class="badge bg-{{ $user->role->name == 'superadmin' ? 'danger' : 'primary' }} mb-3">
          {{ $user->role->display_name }}
        </span>
        <hr>
        <div class="text-start">
          <p class="mb-2">
            <i class="bi bi-envelope me-2 text-muted"></i>
            <small>{{ $user->email }}</small>
          </p>
          <p class="mb-2">
            <i class="bi bi-telephone me-2 text-muted"></i>
            <small>{{ $user->phone }}</small>
          </p>
          <p class="mb-2">
            <i class="bi bi-calendar me-2 text-muted"></i>
            <small>Bergabung: {{ $user->created_at->format('d F Y') }}</small>
          </p>
        </div>
      </div>
    </div>
  </div>

  <div class="col-md-8">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white py-3">
        <h5 class="mb-0 fw-bold">Riwayat Pesanan</h5>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th>Resi</th>
                <th>Pelanggan</th>
                <th>Status</th>
                <th>Total</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @forelse($user->orders as $order)
              <tr>
                <td><span class="badge bg-secondary">{{ $order->resi }}</span></td>
                <td>{{ $order->customer_name }}</td>
                <td>
                  @php
                    $statusClass = match($order->status) {
                      'Menunggu' => 'warning',
                      'Diproses' => 'info',
                      'Selesai' => 'success',
                      'Diambil' => 'primary',
                      default => 'secondary'
                    };
                  @endphp
                  <span class="badge bg-{{ $statusClass }}">{{ $order->status }}</span>
                </td>
                <td class="fw-bold text-primary">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
              </tr>
              @empty
              <tr>
                <td colspan="5" class="text-center text-muted">Belum ada pesanan</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div class="d-flex gap-2 mt-3">
      <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
        <i class="bi bi-pencil me-2"></i>Edit
      </a>
      <a href="{{ route('users.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left me-2"></i>Kembali
      </a>
      @if($user->id !== auth()->id())
      <form action="{{ route('users.destroy', $user->id) }}" 
            method="POST" 
            onsubmit="return confirm('Yakin ingin menghapus user ini?')"
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
</div>
@endsection