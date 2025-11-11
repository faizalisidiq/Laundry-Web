@extends('layouts.app')

@section('title', 'Dashboard - Laundry System')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistik Utama -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center">
        <div class="text-primary mb-2">
          <i class="bi bi-basket3 fs-1"></i>
        </div>
        <h6 class="text-muted">Total Layanan</h6>
        <h3 class="fw-bold text-primary">{{ $totalLayanan }}</h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center">
        <div class="text-success mb-2">
          <i class="bi bi-receipt fs-1"></i>
        </div>
        <h6 class="text-muted">Total Pesanan</h6>
        <h3 class="fw-bold text-success">{{ $totalPesanan }}</h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center">
        <div class="text-warning mb-2">
          <i class="bi bi-people fs-1"></i>
        </div>
        <h6 class="text-muted">Total Pelanggan</h6>
        <h3 class="fw-bold text-warning">{{ $totalPelanggan }}</h3>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card border-0 shadow-sm">
      <div class="card-body text-center">
        <div class="text-danger mb-2">
          <i class="bi bi-cash-stack fs-1"></i>
        </div>
        <h6 class="text-muted">Total Pendapatan</h6>
        <h3 class="fw-bold text-danger">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
      </div>
    </div>
  </div>
</div>

<!-- Status Pesanan -->
<div class="row g-3 mb-4">
  <div class="col-md-3">
    <div class="card border-0 shadow-sm border-start border-warning border-4">
      <div class="card-body">
        <h6 class="text-muted mb-2">Menunggu</h6>
        <h4 class="fw-bold">{{ $pesananMenunggu }}</h4>
        <small class="text-muted">Pesanan baru</small>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card border-0 shadow-sm border-start border-info border-4">
      <div class="card-body">
        <h6 class="text-muted mb-2">Diproses</h6>
        <h4 class="fw-bold">{{ $pesananDiproses }}</h4>
        <small class="text-muted">Sedang dikerjakan</small>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card border-0 shadow-sm border-start border-success border-4">
      <div class="card-body">
        <h6 class="text-muted mb-2">Selesai</h6>
        <h4 class="fw-bold">{{ $pesananSelesai }}</h4>
        <small class="text-muted">Siap diambil</small>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card border-0 shadow-sm border-start border-primary border-4">
      <div class="card-body">
        <h6 class="text-muted mb-2">Diambil</h6>
        <h4 class="fw-bold">{{ $pesananDiambil }}</h4>
        <small class="text-muted">Transaksi selesai</small>
      </div>
    </div>
  </div>
</div>

<div class="row g-3">
  <!-- Aktivitas Terbaru -->
  <div class="col-md-8">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Aktivitas Terbaru</h5>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <th>Resi</th>
                <th>Pelanggan</th>
                <th>Status</th>
                <th>Total</th>
                <th>Tanggal</th>
              </tr>
            </thead>
            <tbody>
              @forelse($aktivitasTerbaru as $order)
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
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
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
  </div>

  <!-- Layanan Terpopuler -->
  <div class="col-md-4">
    <div class="card border-0 shadow-sm">
      <div class="card-body">
        <h5 class="fw-bold mb-3">Layanan Terpopuler</h5>
        <ul class="list-group list-group-flush">
          @forelse($layananTerpopuler as $layanan)
          <li class="list-group-item d-flex justify-content-between align-items-center">
            {{ $layanan->nama_layanan }}
            <span class="badge bg-primary rounded-pill">{{ $layanan->total }}</span>
          </li>
          @empty
          <li class="list-group-item text-center text-muted">Belum ada data</li>
          @endforelse
        </ul>

        <div class="mt-4 p-3 bg-light rounded">
          <h6 class="text-muted mb-2">Pendapatan Bulan Ini</h6>
          <h4 class="fw-bold text-success mb-0">
            Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}
          </h4>
          <small class="text-muted">{{ date('F Y') }}</small>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection