<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - Laundry</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
    .status-badge {
      font-size: 0.75rem;
      padding: 0.25rem 0.5rem;
    }
  </style>
</head>
<body>

  <!-- Sidebar -->
  <div class="sidebar">
    <h4 class="text-center text-white mb-4 fw-bold">Laundry Admin</h4>
    <a href="{{ route('dashboard') }}" class="active">🏠 Dashboard</a>
    <a href="{{ route('layanan.index') }}">🧺 Layanan</a>
      <a href="{{ route('pesanan.index') }}" class="{{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
        📋 Pesanan
    </a>
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
      <span class="navbar-brand mb-0 h5">Dashboard</span>
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
      <!-- Statistik Utama -->
      <div class="row g-3 mb-4">
        <div class="col-md-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <h6 class="text-muted">Total Layanan</h6>
              <h3 class="fw-bold text-primary">{{ $totalLayanan }}</h3>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <h6 class="text-muted">Total Pesanan</h6>
              <h3 class="fw-bold text-success">{{ $totalPesanan }}</h3>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <h6 class="text-muted">Total Pelanggan</h6>
              <h3 class="fw-bold text-warning">{{ $totalPelanggan }}</h3>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
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
              <h6 class="text-muted">Menunggu</h6>
              <h4 class="fw-bold">{{ $pesananMenunggu }}</h4>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm border-start border-info border-4">
            <div class="card-body">
              <h6 class="text-muted">Diproses</h6>
              <h4 class="fw-bold">{{ $pesananDiproses }}</h4>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm border-start border-success border-4">
            <div class="card-body">
              <h6 class="text-muted">Selesai</h6>
              <h4 class="fw-bold">{{ $pesananSelesai }}</h4>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm border-start border-primary border-4">
            <div class="card-body">
              <h6 class="text-muted">Diambil</h6>
              <h4 class="fw-bold">{{ $pesananDiambil }}</h4>
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
                        <span class="badge bg-{{ $statusClass }} status-badge">{{ $order->status }}</span>
                      </td>
                      <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
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

              <div class="mt-4">
                <h6 class="text-muted">Pendapatan Bulan Ini</h6>
                <h4 class="fw-bold text-success">Rp {{ number_format($pendapatanBulanIni, 0, ',', '.') }}</h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
