<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
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
    <h4 class="text-center text-white mb-4 fw-bold">Admin Panel</h4>
    <a href="#" class="active">🏠 Dashboard</a>
    <a href="#">📦 Produk</a>
    <a href="#">🧾 Pesanan</a>
    <a href="#">👥 Pelanggan</a>
    <a href="#">⚙️ Pengaturan</a>
    <a href="logout">🚪 Logout</a>
  </div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h5">Dashboard</span>
      <div class="d-flex align-items-center">
        <span class="me-3 text-secondary">Halo, {{ Auth::user()->name ?? 'Admin' }}</span>
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name ?? 'Admin') }}"
             class="rounded-circle" width="40" height="40" alt="User Avatar">
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="content">
    <div class="container-fluid mt-4">
      <div class="row g-3">
        <div class="col-md-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <h6 class="text-muted">Total Produk</h6>
              <h3 class="fw-bold text-primary">120</h3>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <h6 class="text-muted">Total Pesanan</h6>
              <h3 class="fw-bold text-success">75</h3>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <h6 class="text-muted">Total Pelanggan</h6>
              <h3 class="fw-bold text-warning">45</h3>
            </div>
          </div>
        </div>

        <div class="col-md-3">
          <div class="card border-0 shadow-sm">
            <div class="card-body text-center">
              <h6 class="text-muted">Pendapatan</h6>
              <h3 class="fw-bold text-danger">Rp 12.5 jt</h3>
            </div>
          </div>
        </div>
      </div>

      <div class="mt-4 card border-0 shadow-sm">
        <div class="card-body">
          <h5 class="fw-bold mb-3">Aktivitas Terbaru</h5>
          <ul class="list-group list-group-flush">
            <li class="list-group-item">🧾 Pesanan baru dari <b>John Doe</b></li>
            <li class="list-group-item">📦 Produk <b>Frame Kacamata A123</b> diperbarui</li>
            <li class="list-group-item">👥 Pelanggan baru <b>Jane Smith</b> mendaftar</li>
          </ul>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
