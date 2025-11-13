<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', '🧺 Laundry System')</title>
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
      background: linear-gradient(135deg, #ff9d13ff 30%, #F5C16B 100%);
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

       nav[role="navigation"] svg {
  width: 16px !important;   /* default 20px */
  height: 16px !important;
}

/* Jika masih terasa besar, ubah jadi 14px */
nav[role="navigation"] svg {
  width: 14px !important;
  height: 14px !important;
  padding top: 10px;
}

/* Opsional: atur font dan jarak tombol pagination */
nav[role="navigation"] span,
nav[role="navigation"] a {
  font-size: 14px !important;
  height: 14px !important;
  padding: 4px 8px !important;
}

.text-sm.text-gray-700.leading-5.dark\:text-gray-400 {
    display: none !important;
}


        .bubbles {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            background: radial-gradient(circle at 40% 40%, 
                rgba(24, 186, 255, 0.5), 
                rgba(255, 189, 145, 0.3));
            opacity: 0.7;
            animation: floatBubble linear infinite;
            box-shadow: 
                inset 0 10px 20px rgba(255, 255, 255, 0.3),
                0 4px 15px rgba(52, 152, 219, 0.2);
        }

        .bubble::before {
            content: '';
            position: absolute;
            top: 10%;
            left: 15%;
            width: 40%;
            height: 40%;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.6), transparent);
            border-radius: 50%;
        }

        .bubble:nth-child(1) {
            width: 90px;
            height: 90px;
            left: 8%;
            bottom: -100px;
            animation-duration: 12s;
            animation-delay: 0s;
            background: radial-gradient(circle at 30% 30%, rgba(52, 152, 219, 0.6), rgba(255, 154, 86, 0.4));
        }

        .bubble:nth-child(2) {
            width: 60px;
            height: 60px;
            left: 22%;
            bottom: -80px;
            animation-duration: 14s;
            animation-delay: 2s;
            background: radial-gradient(circle at 30% 30%, rgba(100, 181, 246, 0.5), rgba(255, 167, 38, 0.3));
        }

        .bubble:nth-child(3) {
            width: 45px;
            height: 45px;
            left: 42%;
            bottom: -60px;
            animation-duration: 10s;
            animation-delay: 4s;
        }

        .bubble:nth-child(4) {
            width: 75px;
            height: 75px;
            left: 58%;
            bottom: -90px;
            animation-duration: 13s;
            animation-delay: 1s;
            background: radial-gradient(circle at 30% 30%, rgba(66, 165, 245, 0.55), rgba(255, 183, 77, 0.35));
        }

        .bubble:nth-child(5) {
            width: 50px;
            height: 50px;
            left: 73%;
            bottom: -70px;
            animation-duration: 11s;
            animation-delay: 3s;
        }

        .bubble:nth-child(6) {
            width: 85px;
            height: 85px;
            left: 88%;
            bottom: -95px;
            animation-duration: 15s;
            animation-delay: 0.5s;
            background: radial-gradient(circle at 30% 30%, rgba(41, 128, 185, 0.6), rgba(255, 193, 7, 0.4));
        }

        .bubble:nth-child(7) {
            width: 55px;
            height: 55px;
            left: 12%;
            bottom: -75px;
            animation-duration: 12.5s;
            animation-delay: 2.5s;
        }

        .bubble:nth-child(8) {
            width: 65px;
            height: 65px;
            left: 35%;
            bottom: -85px;
            animation-duration: 13.5s;
            animation-delay: 1.8s;
            background: radial-gradient(circle at 30% 30%, rgba(30, 136, 229, 0.5), rgba(255, 160, 0, 0.35));
        }

        .bubble:nth-child(9) {
            width: 70px;
            height: 70px;
            left: 65%;
            bottom: -80px;
            animation-duration: 11.5s;
            animation-delay: 3.5s;
        }

        .bubble:nth-child(10) {
            width: 40px;
            height: 40px;
            left: 80%;
            bottom: -60px;
            animation-duration: 10.5s;
            animation-delay: 4.5s;
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
