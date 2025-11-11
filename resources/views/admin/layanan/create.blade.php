<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Layanan - Laundry Admin</title>
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
      <span class="navbar-brand mb-0 h5">Tambah Layanan</span>
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
              <h5 class="mb-0 fw-bold">Form Tambah Layanan</h5>
            </div>
            <div class="card-body">
              <form action="{{ route('layanan.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                  <label for="nama_layanan" class="form-label fw-bold">Nama Layanan <span class="text-danger">*</span></label>
                  <input type="text" 
                         class="form-control @error('nama_layanan') is-invalid @enderror" 
                         id="nama_layanan" 
                         name="nama_layanan" 
                         value="{{ old('nama_layanan') }}"
                         placeholder="Contoh: Cuci Kering"
                         required>
                  @error('nama_layanan')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="mb-3">
                  <label for="deskripsi" class="form-label fw-bold">Deskripsi <span class="text-danger">*</span></label>
                  <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                            id="deskripsi" 
                            name="deskripsi" 
                            rows="4"
                            placeholder="Masukkan deskripsi layanan..."
                            required>{{ old('deskripsi') }}</textarea>
                  @error('deskripsi')
                    <div class="invalid-feedback">{{ $message }}</div>
                  @enderror
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="harga" class="form-label fw-bold">Harga per Kg <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" 
                               class="form-control @error('harga') is-invalid @enderror" 
                               id="harga" 
                               name="harga" 
                               value="{{ old('harga') }}"
                               placeholder="5000"
                               min="0"
                               step="100"
                               required>
                        @error('harga')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="durasi_hari" class="form-label fw-bold">Durasi Pengerjaan <span class="text-danger">*</span></label>
                      <div class="input-group">
                        <input type="number" 
                               class="form-control @error('durasi_hari') is-invalid @enderror" 
                               id="durasi_hari" 
                               name="durasi_hari" 
                               value="{{ old('durasi_hari') }}"
                               placeholder="2"
                               min="1"
                               required>
                        <span class="input-group-text">Hari</span>
                        @error('durasi_hari')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                    </div>
                  </div>
                </div>

                <div class="d-flex gap-2 mt-4">
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Simpan
                  </button>
                  <a href="{{ route('layanan.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-2"></i>Kembali
                  </a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>