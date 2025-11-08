<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Pesanan - Laundry Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <style>
    body {
      background-color: #f8f9fa;
      min-height: 100vh;
      overflow-x: hidden;
    }
    .sidebar {
      width: 240px;
      height: 100vh;
      position: fixed;
      left: 0;
      top: 0;
      background: #0d6efd;
      color: #fff;
      padding-top: 1rem;
      z-index: 1000;
    }
    .sidebar a {
      color: #ffffffcc;
      text-decoration: none;
      display: block;
      padding: 10px 20px;
      transition: 0.3s;
    }
    .sidebar a:hover, .sidebar a.active {
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
    }
    .content {
      margin-left: 240px;
      padding: 20px;
    }
    .navbar {
      margin-left: 240px;
      background: #ffffff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center text-white mb-4 fw-bold">Laundry Admin</h4>
    <a href="{{ route('dashboard') }}">🏠 Dashboard</a>
    <a href="{{ route('layanan.index') }}">🧺 Layanan</a>
    <a href="{{ route('pesanan.index') }}" class="active">📋 Pesanan</a>
    <a href="#">👥 Pelanggan</a>
    <a href="#">⚙️ Pengaturan</a>
    <form action="{{ route('logout') }}" method="POST" class="d-inline">
      @csrf
      <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">🚪 Logout</a>
    </form>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h5">Kelola Pesanan</span>
      <div class="d-flex align-items-center">
        <span class="me-3 text-secondary">Halo, {{ Auth::user()->name }}</span>
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
             class="rounded-circle" width="40" height="40" alt="User Avatar">
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="content">
    <div class="container-fluid mt-4">
      
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
        <h4 class="fw-bold mb-0">Daftar Pesanan</h4>
        <a href="{{ route('pesanan.create') }}" class="btn btn-primary">
          <i class="bi bi-plus-circle me-2"></i>Tambah Pesanan
        </a>
      </div>

      <!-- Filter & Search -->
      <div class="card border-0 shadow-sm mb-3">
        <div class="card-body">
          <form action="{{ route('pesanan.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
              <label class="form-label">Status</label>
              <select name="status" class="form-select">
                <option value="">Semua Status</option>
                <option value="Menunggu" {{ request('status') == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                <option value="Diambil" {{ request('status') == 'Diambil' ? 'selected' : '' }}>Diambil</option>
              </select>
            </div>
            <div class="col-md-6">
              <label class="form-label">Cari (Resi/Nama/Telepon)</label>
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
                  <th width="10%">Resi</th>
                  <th width="15%">Pelanggan</th>
                  <th width="12%">Telepon</th>
                  <th width="10%">Status</th>
                  <th width="12%">Total Harga</th>
                  <th width="13%">Tgl Pesan</th>
                  <th width="13%">Tgl Selesai</th>
                  <th width="10%" class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                @forelse($orders as $index => $order)
                <tr>
                  <td>{{ $orders->firstItem() + $index }}</td>
                  <td><span class="badge bg-secondary">{{ $order->resi }}</span></td>
                  <td class="fw-bold">{{ $order->customer_name }}</td>
                  <td>{{ $order->phone }}</td>
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
                  <td class="text-primary fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                  <td>{{ \Carbon\Carbon::parse($order->tanggal_pemesanan)->format('d/m/Y H:i') }}</td>
                  <td>{{ \Carbon\Carbon::parse($order->tanggal_selesai)->format('d/m/Y H:i') }}</td>
                  <td class="text-center">
                    <div class="btn-group btn-group-sm" role="group">
                      <a href="{{ route('pesanan.show', $order->id) }}" 
                         class="btn btn-info" title="Detail">
                        <i class="bi bi-eye"></i>
                      </a>
                      <a href="{{ route('pesanan.edit', $order->id) }}" 
                         class="btn btn-warning" title="Edit">
                        <i class="bi bi-pencil"></i>
                      </a>
                      <form action="{{ route('pesanan.destroy', $order->id) }}" 
                            method="POST" 
                            onsubmit="return confirm('Yakin ingin menghapus pesanan ini?')"
                            class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" title="Hapus">
                          <i class="bi bi-trash"></i>
                        </button>
                      </form>
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="9" class="text-center text-muted py-4">
                    <i class="bi bi-inbox display-4 d-block mb-2"></i>
                    Belum ada pesanan
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          <!-- Pagination -->
          <div class="d-flex justify-content-end mt-3">
            {{ $orders->links() }}
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>