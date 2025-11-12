<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Laundry System')</title>
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
      background: linear-gradient(180deg, #0d6efd 0%, #0a58ca 100%);
      color: #fff;
      padding-top: 1rem;
      padding-bottom: 2rem;
      z-index: 1000;
      display: flex;
      flex-direction: column;
      overflow-y: auto;
    }
    .sidebar a {
      color: #ffffffcc;
      text-decoration: none;
      display: block;
      padding: 12px 20px;
      transition: all 0.3s;
      border-left: 3px solid transparent;
    }
    .sidebar a:hover {
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      border-left-color: #fff;
    }
    .sidebar a.active {
      background: rgba(255, 255, 255, 0.2);
      color: #fff;
      border-left-color: #fff;
      font-weight: 600;
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
    @yield('styles')
  </style>
</head>

<body>

  @include('components.sidebar')

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h5">@yield('page-title', 'Dashboard')</span>
      <div class="d-flex align-items-center">
        <span class="me-3 text-secondary">Halo, {{ Auth::user()->name }}</span>
        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=0d6efd&color=fff"
             class="rounded-circle" width="40" height="40" alt="User Avatar">
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="content">
    <div class="container-fluid mt-4">

      <!-- Alert Messages -->
      @if(session('success'))
      <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      @if(session('error'))
      <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
      </div>
      @endif

      @yield('content')

    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(successAlert);
                bsAlert.close();
            }, 3000); // 3000ms = 3 detik
        }
        const errorAlert = document.getElementById('errorAlert');
        if (errorAlert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(errorAlert);
                bsAlert.close();
            }, 5000); // 5000ms = 5 detik
        }
    </script>
</body>
</html>
