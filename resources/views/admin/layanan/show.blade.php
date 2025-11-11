<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Layanan - Laundry Admin</title>
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



  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h5">Detail Layanan</span>
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
      
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0 fw-bold">Detail Layanan</h5>
            </div>
            <div class="card-body">
              
              <div class="row mb-3">
                <div class="col-md-4">
                  <strong class="text-muted">Nama Layanan</strong>
                </div>
                <div class="col-md-8">
                  <p class="mb-0 fw-bold fs-5">{{ $layanan->nama_layanan }}</p>
                </div>
              </div>

              <hr>

              <div class="row mb-3">
                <div class="col-md-4">
                  <strong class="text-muted">Deskripsi</strong>
                </div>
                <div class="col-md-8">
                  <p class="mb-0">{{ $layanan->deskripsi }}</p>
                </div>
              </div>

              <hr>

              <div class="row mb-3">
                <div class="col-md-4">
                  <strong class="text-muted">Harga per Kg</strong>
                </div>
                <div class="col-md-8">
                  <p class="mb-0 text-primary fw-bold fs-5">
                    Rp {{ number_format($layanan->harga, 0, ',', '.') }}
                  </p>
                </div>
              </div>

              <hr>

              <div class="row mb-3">
                <div class="col-md-4">
                  <strong class="text-muted">Durasi Pengerjaan</strong>
                </div>
                <div class="col-md-8">
                  <span class="badge bg-info fs-6">{{ $layanan->durasi_hari }} Hari</span>
                </div>
              </div>

              <hr>

              <div class="row mb-3">
                <div class="col-md-4">
                  <strong class="text-muted">Dibuat Pada</strong>
                </div>
                <div class="col-md-8">
                  <p class="mb-0">{{ $layanan->created_at->format('d/m/Y H:i') }}</p>
                </div>
              </div>

              <hr>

              <div class="row mb-3">
                <div class="col-md-4">
                  <strong class="text-muted">Terakhir Diubah</strong>
                </div>
                <div class="col-md-8">
                  <p class="mb-0">{{ $layanan->updated_at->format('d/m/Y H:i') }}</p>
                </div>
              </div>

              <div class="d-flex gap-2 mt-4">
                <a href="{{ route('layanan.edit', $layanan->id) }}" class="btn btn-warning">
                  <i class="bi bi-pencil me-2"></i>Edit
                </a>
                <a href="{{ route('layanan.index') }}" class="btn btn-secondary">
                  <i class="bi bi-arrow-left me-2"></i>Kembali
                </a>
                <form action="{{ route('layanan.destroy', $layanan->id) }}" 
                      method="POST" 
                      onsubmit="return confirm('Yakin ingin menghapus layanan ini?')"
                      class="d-inline ms-auto">
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

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>