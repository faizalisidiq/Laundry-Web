
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah Pesanan - Laundry Admin</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  
  <!-- Select2 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
  
  <style>
    /* ===== GLOBAL STYLES ===== */
    body {
      background-color: #f8f9fa;
      min-height: 100vh;
      overflow-x: hidden;
      padding-bottom: 80px;
    }
    
    html {
      scroll-behavior: smooth;
    }
    
    /* ===== NAVBAR ===== */
    .navbar {
      background: #ffffff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
      position: sticky;
      top: 0;
      z-index: 999;
      padding: 10px 15px;
    }
    
    .navbar .navbar-brand {
      font-size: 1.1rem;
      font-weight: 600;
    }
    
    .navbar img {
      width: 38px;
      height: 38px;
    }
    
    .navbar .user-name {
      display: none;
    }
    
    @media (min-width: 576px) {
      .navbar .user-name {
        display: inline-block;
      }
      .navbar .navbar-brand {
        font-size: 1.25rem;
      }
      .navbar img {
        width: 40px;
        height: 40px;
      }
    }
    
    /* ===== CONTENT LAYOUT ===== */
    .content {
      padding: 15px 10px;
      width: 100%;
    }
    
    @media (min-width: 576px) {
      .content {
        padding: 20px 15px;
      }
    }
    
    @media (min-width: 992px) {
      .content {
        padding: 30px;
      }
      
      body {
        padding-bottom: 0;
      }
    }
    
    /* ===== CARD ===== */
    .card {
      border-radius: 12px;
      border: none;
      box-shadow: 0 2px 8px rgba(0,0,0,0.08);
      margin-bottom: 20px;
    }
    
    @media (max-width: 575px) {
      .card {
        border-radius: 0;
        margin-left: -10px;
        margin-right: -10px;
        margin-bottom: 15px;
      }
    }
    
    .card-header {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 15px !important;
      border-radius: 12px 12px 0 0 !important;
    }
    
    @media (max-width: 575px) {
      .card-header {
        border-radius: 0 !important;
      }
    }
    
    .card-header h5 {
      font-size: 1rem;
      margin: 0;
    }
    
    @media (min-width: 576px) {
      .card-header h5 {
        font-size: 1.25rem;
      }
    }
    
    .card-body {
      padding: 15px;
    }
    
    @media (min-width: 576px) {
      .card-body {
        padding: 25px;
      }
    }
    
    /* ===== FORM CONTROLS ===== */
    .form-control, .form-select {
      font-size: 16px;
      min-height: 48px;
      padding: 12px 15px;
      border-radius: 8px;
      border: 1px solid #dee2e6;
      transition: all 0.3s;
    }
    
    .form-control:focus, .form-select:focus {
      border-color: #667eea;
      box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    
    .form-label {
      font-size: 14px;
      margin-bottom: 8px;
      color: #495057;
      font-weight: 500;
    }
    
    /* ===== LAYANAN ITEM ===== */
    .layanan-item {
      background: #ffffff;
      padding: 15px;
      border-radius: 10px;
      margin-bottom: 15px;
      border: 2px solid #e9ecef;
      box-shadow: 0 2px 4px rgba(0,0,0,0.05);
      animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
      from {
        opacity: 0;
        transform: translateY(-10px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .layanan-item .row {
      row-gap: 15px;
    }
    
    @media (max-width: 767px) {
      .layanan-item .col-md-6,
      .layanan-item .col-md-3,
      .layanan-item .col-md-2 {
        width: 100%;
        padding: 0 12px;
      }
      
      .layanan-item .col-md-1 {
        width: 100%;
        margin-top: 10px;
      }
    }
    
    /* ===== PAYMENT SUMMARY ===== */
    .payment-summary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 20px;
      border-radius: 12px;
      box-shadow: 0 8px 16px rgba(102, 126, 234, 0.3);
      margin-top: 20px;
    }
    
    @media (min-width: 768px) {
      .payment-summary {
        margin-top: 0;
      }
    }
    
    .payment-summary .fs-5 {
      font-size: 1.2rem !important;
    }
    
    @media (min-width: 576px) {
      .payment-summary .fs-5 {
        font-size: 1.5rem !important;
      }
    }
    
    /* ===== BUTTONS ===== */
    .btn {
      min-height: 48px;
      padding: 12px 24px;
      font-size: 15px;
      font-weight: 500;
      border-radius: 8px;
      transition: all 0.3s;
    }
    
    .btn-sm {
      min-height: 42px;
      padding: 10px 18px;
      font-size: 14px;
    }
    
    .btn-primary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      border: none;
    }
    
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    
    .btn:disabled {
      opacity: 0.6;
      cursor: not-allowed;
    }
    
    /* ===== SELECT2 CUSTOMIZATION ===== */
    .select2-container--bootstrap-5 .select2-selection {
      min-height: 48px !important;
      border: 1px solid #dee2e6 !important;
      font-size: 16px !important;
      border-radius: 8px !important;
    }
    
    .select2-container--bootstrap-5 .select2-selection--single {
      padding: 12px 15px !important;
    }
    
    .select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
      padding: 0 !important;
      line-height: 24px !important;
    }
    
    .select2-results__option {
      padding: 12px 15px !important;
      font-size: 15px;
    }
    
    .select2-results__option--highlighted {
      background-color: #667eea !important;
    }
    
    .select2-container--bootstrap-5 .select2-dropdown {
      border-radius: 8px;
      border: 1px solid #dee2e6;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* ===== BADGES ===== */
    .badge-customer-new {
      background-color: #28a745;
      color: white;
      font-size: 10px;
      padding: 4px 8px;
      border-radius: 4px;
      margin-left: 5px;
      font-weight: 600;
    }
    
    .badge-customer-old {
      background-color: #17a2b8;
      color: white;
      font-size: 10px;
      padding: 4px 8px;
      border-radius: 4px;
      margin-left: 5px;
      font-weight: 600;
    }
    
    @media (min-width: 576px) {
      .badge-customer-new,
      .badge-customer-old {
        font-size: 11px;
        padding: 4px 10px;
      }
    }
    
    /* ===== TOAST NOTIFICATION ===== */
    .toast-notification {
      position: fixed;
      top: 70px;
      right: 10px;
      left: 10px;
      z-index: 9999;
    }
    
    @media (min-width: 576px) {
      .toast-notification {
        left: auto;
        right: 20px;
        max-width: 350px;
      }
    }
    
    .toast {
      width: 100%;
      border-radius: 8px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    
    /* ===== ALERTS ===== */
    .alert {
      font-size: 14px;
      padding: 12px 15px;
      margin-bottom: 15px;
      border-radius: 8px;
      border-left: 4px solid;
    }
    
    .alert-info {
      border-left-color: #0dcaf0;
    }
    
    .alert-danger {
      border-left-color: #dc3545;
    }
    
    .alert ul {
      padding-left: 20px;
      margin-bottom: 0;
      margin-top: 5px;
    }
    
    /* ===== BOTTOM ACTIONS (MOBILE) ===== */
    .bottom-actions {
      display: none;
    }
    
    @media (max-width: 767px) {
      .bottom-actions {
        display: flex;
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        background: white;
        padding: 12px 15px;
        box-shadow: 0 -4px 12px rgba(0,0,0,0.1);
        z-index: 998;
        gap: 10px;
      }
      
      .bottom-actions .btn {
        flex: 1;
      }
      
      .desktop-actions {
        display: none;
      }
    }
    
    @media (min-width: 768px) {
      .bottom-actions {
        display: none;
      }
      
      .desktop-actions {
        display: flex;
        gap: 10px;
        margin-top: 20px;
      }
    }
    
    /* ===== UTILITIES ===== */
    small {
      font-size: 13px;
      color: #6c757d;
    }
    
    hr {
      margin: 25px 0;
      opacity: 0.1;
    }
    
    .input-group-text {
      min-width: 50px;
      justify-content: center;
      background: #f8f9fa;
      border-radius: 8px 0 0 8px;
    }
    
    @media (max-width: 575px) {
      .col-form-label {
        padding-top: 0;
      }
    }
  </style>
</head>
<body>

  <!-- Toast Container -->
  <div class="toast-notification" id="toastContainer"></div>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <span class="navbar-brand mb-0">
        <i class="bi bi-plus-circle-fill text-primary me-2"></i>Tambah Pesanan
      </span>
      <div class="d-flex align-items-center">
        <span class="user-name me-3 text-secondary">Halo, {{ Auth::user()->name }}</span>
        <img src="https://ui-avatars.com/api/?name={{ Auth::user()->name }}"
             class="rounded-circle" alt="User Avatar">
      </div>
    </div>
  </nav>

  <!-- Main Content -->
  <div class="content">
    <div class="container-fluid">
      
      <div class="row justify-content-center">
        <div class="col-12 col-lg-11 col-xl-10">
          <div class="card">
            <div class="card-header">
              <h5>
                <i class="bi bi-plus-circle-fill me-2"></i>Form Tambah Pesanan
              </h5>
            </div>
            <div class="card-body">
              
              <!-- Alert Info -->
              <div class="alert alert-info alert-dismissible fade show" role="alert">
                <i class="bi bi-lightbulb-fill me-2"></i>
                <strong>Tips:</strong> Ketik nama pelanggan yang sudah pernah pesan, nomor telepon akan terisi otomatis!
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>

              <!-- Alert Errors -->
              @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0 mt-2">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
              @endif

              <form action="{{ route('pesanan.store') }}" method="POST" id="formPesanan">
                @csrf

                <!-- Data Pelanggan -->
                <div class="row">
                  <div class="col-12 col-md-6">
                    <div class="mb-3">
                      <label for="customer_name" class="form-label fw-bold">
                        Nama Pelanggan <span class="text-danger">*</span>
                      </label>
                      <select id="customer_name" 
                              name="customer_name" 
                              class="form-select" 
                              required>
                        <option value="">-- Pilih atau Ketik Nama Baru --</option>
                      </select>
                      <small class="text-muted">
                        <i class="bi bi-search me-1"></i>Ketik minimal 1 huruf untuk mencari pelanggan lama
                      </small>
                    </div>
                  </div>

                  <div class="col-12 col-md-6">
                    <div class="mb-3">
                      <label for="phone" class="form-label fw-bold">
                        Nomor Telepon <span class="text-danger">*</span>
                        <span id="phone-status-badge"></span>
                      </label>
                      <input type="text" 
                             class="form-control" 
                             id="phone" 
                             name="phone" 
                             placeholder="08xxxxxxxxxx"
                             value="{{ old('phone') }}"
                             required>
                      <small class="text-muted" id="phone-helper">
                        <i class="bi bi-info-circle me-1"></i>Nomor akan terisi otomatis jika pelanggan sudah pernah pesan
                      </small>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label for="tanggal_pemesanan" class="form-label fw-bold">
                    Tanggal Pemesanan <span class="text-danger">*</span>
                  </label>
                  <input type="datetime-local" 
                         class="form-control" 
                         id="tanggal_pemesanan" 
                         name="tanggal_pemesanan" 
                         value="{{ old('tanggal_pemesanan') }}"
                         required>
                </div>

                <hr>

                <!-- Layanan -->
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                  <h6 class="fw-bold mb-0">
                    <i class="bi bi-basket3-fill text-primary me-2"></i>Layanan <span class="text-danger">*</span>
                  </h6>
                  <button type="button" class="btn btn-sm btn-primary" onclick="addLayanan()">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Layanan
                  </button>
                </div>

                <div id="layananContainer">
                  <div class="layanan-item" data-index="0">
                    <div class="row">
                      <div class="col-12 col-md-6">
                        <label class="form-label fw-bold">Pilih Layanan</label>
                        <select name="layanan_id[]" class="form-select layanan-select" required onchange="updateHarga(this)">
                          <option value="">-- Pilih Layanan --</option>
                          @foreach($layanans as $layanan)
                          <option value="{{ $layanan->id }}" 
                                  data-harga="{{ $layanan->harga }}"
                                  data-durasi="{{ $layanan->durasi_hari }}">
                            {{ $layanan->nama_layanan }} (Rp {{ number_format($layanan->harga, 0, ',', '.') }}/kg - {{ $layanan->durasi_hari }} hari)
                          </option>
                          @endforeach
                        </select>
                      </div>
                      <div class="col-6 col-md-3">
                        <label class="form-label fw-bold">Berat (Kg)</label>
                        <input type="number" 
                               name="berat[]" 
                               class="form-control berat-input" 
                               step="0.1" 
                               min="0.1" 
                               required
                               onchange="calculateSubtotal(this)">
                      </div>
                      <div class="col-6 col-md-2">
                        <label class="form-label fw-bold">Subtotal</label>
                        <input type="text" class="form-control subtotal-display" readonly value="Rp 0">
                      </div>
                      <div class="col-12 col-md-1">
                        <label class="form-label fw-bold d-none d-md-block">&nbsp;</label>
                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeLayanan(this)" disabled>
                          <i class="bi bi-trash"></i> Hapus
                        </button>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <!-- Pembayaran -->
                <h6 class="fw-bold mb-3">
                  <i class="bi bi-cash-coin text-success me-2"></i>Informasi Pembayaran
                </h6>
                <div class="row">
                  <div class="col-12 col-md-6 mb-3">
                    <div class="mb-3">
                      <label for="payment_status" class="form-label fw-bold">
                        Status Pembayaran <span class="text-danger">*</span>
                      </label>
                      <select name="payment_status" 
                              id="payment_status" 
                              class="form-select" 
                              required
                              onchange="handlePaymentStatusChange()">
                        <option value="Belum Lunas">Belum Lunas</option>
                        <option value="Lunas">Lunas</option>
                      </select>
                      <small class="text-muted">Pilih status pembayaran pesanan</small>
                    </div>

                    <div class="mb-3">
                      <label for="paid_amount" class="form-label fw-bold">Jumlah Dibayar</label>
                      <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" 
                               class="form-control" 
                               id="paid_amount" 
                               name="paid_amount" 
                               value="{{ old('paid_amount', 0) }}"
                               min="0"
                               step="1000"
                               onchange="calculatePaymentDisplay()">
                      </div>
                      <small class="text-muted">Opsional: Masukkan jumlah yang sudah dibayar</small>
                    </div>
                  </div>
                  
                  <div class="col-12 col-md-6">
                    <div class="payment-summary">
                      <div class="d-flex justify-content-between mb-2">
                        <span>Total Tagihan:</span>
                        <strong class="fs-5" id="totalHarga">Rp 0</strong>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span>Dibayar:</span>
                        <strong id="displayPaidAmount">Rp 0</strong>
                      </div>
                      <hr style="border-color: rgba(255,255,255,0.3);">
                      <div class="d-flex justify-content-between">
                        <span>Sisa Tagihan:</span>
                        <strong class="fs-5" id="sisaTagihan">Rp 0</strong>
                      </div>
                      <div class="mt-3">
                        <span class="badge bg-danger" id="paymentStatusBadge" style="font-size: 14px; padding: 10px 20px;">
                          Belum Lunas
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <hr>

                <!-- Desktop Actions -->
                <div class="desktop-actions">
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Simpan Pesanan
                  </button>
                  <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
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

  <!-- Mobile Bottom Actions -->
  <div class="bottom-actions">
    <button type="submit" form="formPesanan" class="btn btn-primary">
      <i class="bi bi-save me-2"></i>Simpan
    </button>
    <a href="{{ route('pesanan.index') }}" class="btn btn-secondary">
      <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
  </div>

  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  
  <!-- Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Select2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

  <script>
    let layananIndex = 1;

    // ============= AUTOCOMPLETE CUSTOMER =============
    $(document).ready(function() {
        // Inisialisasi Select2 dengan AJAX
        $('#customer_name').select2({
            theme: 'bootstrap-5',
            placeholder: '-- Pilih atau Ketik Nama Baru --',
            allowClear: true,
            tags: true,
            minimumInputLength: 1,
            ajax: {
                url: '{{ route("pesanan.customers") }}', 
                dataType: 'json',
                delay: 300,
                data: function (params) {
                    return { q: params.term };
                },
                processResults: function (data) {
                    return { results: data.results };
                },
                cache: true
            },
            templateResult: function(customer) {
                if (customer.loading) return 'Mencari pelanggan...';
                
                if (customer.phone) {
                    return $(`
                        <div>
                            <strong>${customer.text}</strong>
                            <span class="badge-customer-old">PELANGGAN LAMA</span>
                            <br>
                            <small class="text-muted"><i class="bi bi-telephone-fill"></i> ${customer.phone}</small>
                        </div>
                    `);
                }
                
                return $(`
                    <div>
                        <strong>${customer.text}</strong>
                        <span class="badge-customer-new">PELANGGAN BARU</span>
                    </div>
                `);
            },
            templateSelection: function(customer) {
                return customer.text;
            }
        });
        
        // Event saat pelanggan dipilih
        $('#customer_name').on('select2:select', function (e) {
            const data = e.params.data;
            
            if (data.phone) {
                $('#phone').val(data.phone).prop('readonly', false);
                $('#phone-status-badge').html('<span class="badge-customer-old">Auto-filled</span>');
                $('#phone-helper').html('<i class="bi bi-check-circle-fill text-success me-1"></i>Nomor telepon terisi otomatis dari data pelanggan lama');
                showToast('Nomor telepon terisi otomatis!', 'success');
            } else {
                $('#phone').val('').prop('readonly', false).focus();
                $('#phone-status-badge').html('<span class="badge-customer-new">Pelanggan Baru</span>');
                $('#phone-helper').html('<i class="bi bi-pencil-fill text-warning me-1"></i>Silakan isi nomor telepon pelanggan baru');
                showToast('Pelanggan baru, silakan isi nomor telepon', 'info');
            }
        });

        // Event saat dihapus
        $('#customer_name').on('select2:clear', function () {
            $('#phone').val('');
            $('#phone-status-badge').html('');
            $('#phone-helper').html('<i class="bi bi-info-circle me-1"></i>Nomor akan terisi otomatis jika pelanggan sudah pernah pesan');
        });

        // Set default tanggal hari ini
        const now = new Date();
        const localDateTime = new Date(now.getTime() - now.getTimezoneOffset() * 60000).toISOString().slice(0, 16);
        $('#tanggal_pemesanan').val(localDateTime);
    });

    // ============= TOAST NOTIFICATION =============
    function showToast(message, type = 'info') {
        const toastColors = {
            success: 'bg-success',
            error: 'bg-danger',
            warning: 'bg-warning',
            info: 'bg-info'
        };
        
        const toastIcons = {
            success: 'bi-check-circle-fill',
            error: 'bi-x-circle-fill',
            warning: 'bi-exclamation-triangle-fill',
            info: 'bi-info-circle-fill'
        };
        
        const toastHtml = `
            <div class="toast align-items-center text-white ${toastColors[type]} border-0 show" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="bi ${toastIcons[type]} me-2"></i>${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        
        const toastElement = $(toastHtml);
        $('#toastContainer').append(toastElement);
        
        setTimeout(function() {
            toastElement.fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    }

    // ============= LAYANAN MANAGEMENT =============
    function addLayanan() {
      const container = document.getElementById('layananContainer');
      const newLayanan = `
        <div class="layanan-item" data-index="${layananIndex}">
          <div class="row">
            <div class="col-12 col-md-6">
              <label class="form-label fw-bold">Pilih Layanan</label>
              <select name="layanan_id[]" class="form-select layanan-select" required onchange="updateHarga(this)">
                <option value="">-- Pilih Layanan --</option>
                @foreach($layanans as $layanan)
                <option value="{{ $layanan->id }}" 
                        data-harga="{{ $layanan->harga }}"
                        data-durasi="{{ $layanan->durasi_hari }}">
                  {{ $layanan->nama_layanan }} (Rp {{ number_format($layanan->harga, 0, ',', '.') }}/kg - {{ $layanan->durasi_hari }} hari)
                </option>
                @endforeach
              </select>
            </div>
            <div class="col-md-3">
              <label class="form-label fw-bold">Berat (Kg)</label>
              <input type="number" 
                     name="berat[]" 
                     class="form-control berat-input" 
                     step="0.1" 
                     min="0.1" 
                     required
                     onchange="calculateSubtotal(this)">
            </div>
            <div class="col-md-2">
              <label class="form-label fw-bold">Subtotal</label>
              <input type="text" class="form-control subtotal-display" readonly value="Rp 0">
            </div>
            <div class="col-md-1">
              <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeLayanan(this)">
                <i class="bi bi-trash"></i>
              </button>
            </div>
          </div>
        </div>
      `;
      container.insertAdjacentHTML('beforeend', newLayanan);
      layananIndex++;
      updateRemoveButtons();
    }

    function removeLayanan(button) {
      button.closest('.layanan-item').remove();
      updateRemoveButtons();
      calculateTotal();
    }

    function updateRemoveButtons() {
      const items = document.querySelectorAll('.layanan-item');
      items.forEach((item) => {
        const removeBtn = item.querySelector('button[onclick*="removeLayanan"]');
        removeBtn.disabled = items.length === 1;
      });
    }

    function updateHarga(select) {
      const parent = select.closest('.layanan-item');
      const beratInput = parent.querySelector('.berat-input');
      
      if (beratInput.value) {
        calculateSubtotal(beratInput);
      }
    }

    function calculateSubtotal(input) {
      const parent = input.closest('.layanan-item');
      const select = parent.querySelector('.layanan-select');
      const selectedOption = select.options[select.selectedIndex];
      const harga = parseFloat(selectedOption.dataset.harga || 0);
      const berat = parseFloat(input.value || 0);
      const subtotal = harga * berat;
      
      parent.querySelector('.subtotal-display').value = 'Rp ' + subtotal.toLocaleString('id-ID');
      
      calculateTotal();
    }

    function calculateTotal() {
      let total = 0;
      document.querySelectorAll('.layanan-item').forEach(item => {
        const select = item.querySelector('.layanan-select');
        const selectedOption = select.options[select.selectedIndex];
        const harga = parseFloat(selectedOption.dataset.harga || 0);
        const berat = parseFloat(item.querySelector('.berat-input').value || 0);
        total += harga * berat;
      });
      
      document.getElementById('totalHarga').textContent = 'Rp ' + total.toLocaleString('id-ID');
      
      const paymentStatus = document.getElementById('payment_status').value;
      if (paymentStatus === 'Lunas') {
        document.getElementById('paid_amount').value = total;
      }
      
      calculatePaymentDisplay();
    }

    function handlePaymentStatusChange() {
      const paymentStatus = document.getElementById('payment_status').value;
      const paidAmountInput = document.getElementById('paid_amount');
      const totalText = document.getElementById('totalHarga').textContent;
      const total = parseFloat(totalText.replace(/[^0-9]/g, ''));
      
      if (paymentStatus === 'Lunas') {
        paidAmountInput.value = total;
      } else {
        paidAmountInput.value = 0;
      }
      
      calculatePaymentDisplay();
    }

    function calculatePaymentDisplay() {
      const totalText = document.getElementById('totalHarga').textContent;
      const total = parseFloat(totalText.replace(/[^0-9]/g, ''));
      const paidAmount = parseFloat(document.getElementById('paid_amount').value || 0);
      const sisa = total - paidAmount;
      const paymentStatus = document.getElementById('payment_status').value;
      
      document.getElementById('displayPaidAmount').textContent = 'Rp ' + paidAmount.toLocaleString('id-ID');
      document.getElementById('sisaTagihan').textContent = 'Rp ' + sisa.toLocaleString('id-ID');
      
      const badge = document.getElementById('paymentStatusBadge');
      if (paymentStatus === 'Lunas') {
        badge.textContent = 'Lunas ✅';
        badge.className = 'badge bg-success';
      } else {
        badge.textContent = 'Belum Lunas';
        badge.className = 'badge bg-danger';
      }
    }

    // Form submit (Real Laravel Submit)
    document.getElementById('formPesanan').addEventListener('submit', function(e) {
        const customerName = $('#customer_name').val();
        const phone = $('#phone').val();
        
        if (!customerName || !phone) {
            e.preventDefault();
            showToast('Nama pelanggan dan nomor telepon harus diisi!', 'error');
            return false;
        }
        
        // Form akan disubmit ke Laravel controller
        showToast('Menyimpan pesanan...', 'info');
    });
  </script>
</body>
</html>