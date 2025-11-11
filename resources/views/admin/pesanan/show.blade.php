@extends('layouts.app')

@section('title', 'Detail Pesanan - Laundry System')
@section('page-title', 'Detail Pesanan')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-10">
    <div class="card border-0 shadow-sm">
      <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Detail Pesanan - {{ $pesanan->resi }}</h5>
        @php
          $statusClass = match($pesanan->status) {
            'Menunggu' => 'warning',
            'Diproses' => 'info',
            'Selesai' => 'success',
            'Diambil' => 'primary',
            default => 'secondary'
          };
        @endphp
        <span class="badge bg-{{ $statusClass }} fs-6">{{ $pesanan->status }}</span>
      </div>
      <div class="card-body">
        
        <!-- Info Pelanggan -->
        <div class="row mb-4">
          <div class="col-md-6">
            <h6 class="text-muted mb-3">Informasi Pelanggan</h6>
            <table class="table table-sm table-borderless">
              <tr>
                <td width="40%" class="text-muted">Nama</td>
                <td class="fw-bold">{{ $pesanan->customer_name }}</td>
              </tr>
              <tr>
                <td class="text-muted">Telepon</td>
                <td class="fw-bold">{{ $pesanan->phone }}</td>
              </tr>
            </table>
          </div>
          <div class="col-md-6">
            <h6 class="text-muted mb-3">Informasi Pesanan</h6>
            <table class="table table-sm table-borderless">
              <tr>
                <td width="40%" class="text-muted">Resi</td>
                <td><span class="badge bg-secondary">{{ $pesanan->resi }}</span></td>
              </tr>
              <tr>
                <td class="text-muted">Admin</td>
                <td class="fw-bold">{{ $pesanan->user->name }}</td>
              </tr>
              <tr>
                <td class="text-muted">Tanggal Pesan</td>
                <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d/m/Y H:i') }}</td>
              </tr>
              <tr>
                <td class="text-muted">Estimasi Selesai</td>
                <td>{{ \Carbon\Carbon::parse($pesanan->tanggal_selesai)->format('d/m/Y H:i') }}</td>
              </tr>
            </table>
          </div>
        </div>

        <hr>

        <!-- Detail Layanan -->
        <h6 class="text-muted mb-3">Detail Layanan</h6>
        <div class="table-responsive">
          <table class="table table-hover">
            <thead class="table-light">
              <tr>
                <th width="5%">No</th>
                <th>Layanan</th>
                <th width="15%">Harga/Kg</th>
                <th width="15%">Berat (Kg)</th>
                <th width="20%" class="text-end">Subtotal</th>
              </tr>
            </thead>
            <tbody>
              @foreach($pesanan->od as $index => $detail)
              <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                  <strong>{{ $detail->layanan->nama_layanan }}</strong>
                  <br>
                  <small class="text-muted">{{ $detail->layanan->deskripsi }}</small>
                </td>
                <td>Rp {{ number_format($detail->harga, 0, ',', '.') }}</td>
                <td>{{ number_format($detail->berat, 1) }} Kg</td>
                <td class="text-end fw-bold text-primary">
                  Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                </td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4" class="text-end fw-bold">Total:</td>
                <td class="text-end fw-bold fs-5 text-success">
                  Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                </td>
              </tr>
            </tfoot>
          </table>
        </div>

        <hr>

        <!-- Actions -->
        <div class="d-flex gap-2">
          <a href="{{ route('pesanan.edit', $pesanan->id) }}" class="btn btn-warning">
            <i class="bi bi-pencil me-2"></i>Edit
          </a>
          <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali
          </a>
          
          <!-- Quick Status Update -->
          @if($pesanan->status != 'Diambil')
          <div class="ms-auto">
            <form action="{{ route('pesanan.updateStatus', $pesanan->id) }}" method="POST" class="d-inline">
              @csrf
              @method('PUT')
              <select name="status" class="form-select form-select-sm d-inline-block w-auto me-2" onchange="this.form.submit()">
                <option value="Menunggu" {{ $pesanan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diproses" {{ $pesanan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Diambil" {{ $pesanan->status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
              </select>
            </form>
          </div>
          @endif

          <form action="{{ route('pesanan.destroy', $pesanan->id) }}" 
                method="POST" 
                onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')"
                class="d-inline">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">
              <i class="bi bi-trash me-2"></i>Hapus
            </button>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection