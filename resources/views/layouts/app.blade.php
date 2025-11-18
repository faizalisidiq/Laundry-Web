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

    .content {
      margin-left: 240px;
      padding: 20px;
      transition: margin-left 0.3s ease;
    }

    .navbar {
      margin-left: 240px;
      background: #ffffff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
      transition: margin-left 0.3s ease;
    }

    /* User info responsive */
    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .user-name {
      display: inline;
    }

    /* Pagination styles */
    nav[role="navigation"] svg {
      width: 14px !important;
      height: 14px !important;
    }

    nav[role="navigation"] span,
    nav[role="navigation"] a {
      font-size: 14px !important;
      padding: 4px 8px !important;
    }

    .text-sm.text-gray-700.leading-5.dark\:text-gray-400 {
      display: none !important;
    }

    /* ========== RESPONSIVE MOBILE ========== */
    @media (max-width: 768px) {
      .content {
        margin-left: 0 !important;
        padding: 15px !important;
        margin-top: 70px; /* Space for fixed navbar */
      }

      .navbar {
        margin-left: 0 !important;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 998;
        padding-left: 60px !important; /* Space for hamburger */
      }

      .navbar .container-fluid {
        padding-left: 10px;
        padding-right: 10px;
      }

      .navbar-brand {
        font-size: 1rem !important;
      }

      .user-name {
        display: none; /* Hide "Halo, Username" on mobile */
      }

      .user-info img {
        width: 35px !important;
        height: 35px !important;
      }

      /* Cards responsive */
      .card {
        margin-bottom: 15px;
      }

      .card-body {
        padding: 15px;
      }

      /* Table responsive */
      .table-responsive {
        font-size: 0.85rem;
      }

      .table th,
      .table td {
        padding: 8px 5px;
        white-space: nowrap;
      }

      /* Button groups */
      .btn-group-sm .btn {
        padding: 4px 6px;
        font-size: 0.75rem;
      }

      /* Form controls */
      .form-select,
      .form-control {
        font-size: 0.9rem;
        padding: 8px 12px;
      }

      /* Alert */
      .alert {
        font-size: 0.9rem;
        padding: 10px 15px;
      }

      /* Dashboard stats cards */
      .col-md-3,
      .col-md-4,
      .col-md-6,
      .col-md-8 {
        margin-bottom: 15px;
      }

      /* Hide table columns on mobile */
      .hide-mobile {
        display: none !important;
      }
    }

    @media (max-width: 480px) {
      .content {
        padding: 10px !important;
      }

      .card-body {
        padding: 12px;
      }

      h4, h5 {
        font-size: 1.1rem;
      }

      h3 {
        font-size: 1.3rem;
      }

      .table {
        font-size: 0.75rem;
      }

      .btn-sm {
        font-size: 0.7rem;
        padding: 3px 5px;
      }

      .badge {
        font-size: 0.7rem;
        padding: 3px 6px;
      }
    }

    /* ========== TABLE RESPONSIVE IMPROVEMENTS ========== */
    @media (max-width: 768px) {
      /* Stack table cells vertically */
      .table-responsive table {
        border: 0;
      }

      .table-responsive table thead {
        display: none;
      }

      .table-responsive table tr {
        display: block;
        margin-bottom: 15px;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: white;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      }

      .table-responsive table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px;
        border: none;
        border-bottom: 1px solid #f0f0f0;
        white-space: normal;
      }

      .table-responsive table td:last-child {
        border-bottom: none;
      }

      .table-responsive table td::before {
        content: attr(data-label);
        font-weight: bold;
        margin-right: 10px;
        color: #6c757d;
        font-size: 0.85rem;
      }

      /* Button group in mobile */
      .table-responsive .btn-group {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        justify-content: flex-end;
        width: 100%;
      }

      .table-responsive .btn-group .btn {
        flex: 0 0 auto;
      }
    }

    /* ========== FORM RESPONSIVE ========== */
    @media (max-width: 768px) {
      .row.g-3 {
        gap: 10px !important;
      }

      .form-label {
        font-size: 0.9rem;
        margin-bottom: 5px;
      }
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
      <div class="user-info">
        <span class="me-3 text-secondary user-name">Halo, {{ Auth::user()->name }}</span>
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
    // Auto dismiss alerts
    const successAlert = document.getElementById('successAlert');
    if (successAlert) {
      setTimeout(function() {
        const bsAlert = new bootstrap.Alert(successAlert);
        bsAlert.close();
      }, 3000);
    }

    const errorAlert = document.getElementById('errorAlert');
    if (errorAlert) {
      setTimeout(function() {
        const bsAlert = new bootstrap.Alert(errorAlert);
        bsAlert.close();
      }, 5000);
    }

    // Add data-label to table cells for mobile view
    document.addEventListener('DOMContentLoaded', function() {
      const tables = document.querySelectorAll('.table-responsive table');
      
      tables.forEach(table => {
        const headers = Array.from(table.querySelectorAll('thead th')).map(th => th.textContent.trim());
        const rows = table.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
          const cells = row.querySelectorAll('td');
          cells.forEach((cell, index) => {
            if (headers[index]) {
              cell.setAttribute('data-label', headers[index]);
            }
          });
        });
      });
    });
  </script>

  @yield('scripts')
</body>
</html>