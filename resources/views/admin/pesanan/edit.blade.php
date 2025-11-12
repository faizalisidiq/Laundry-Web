<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pesanan - Laundry Admin</title>
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
      margin-left: 0px;
      background: #ffffff;
      box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    .layanan-item {
      background: #f8f9fa;
      padding: 15px;
      border-radius: 8px;
      margin-bottom: 10px;
      border: 1px solid #dee2e6;
    }
    .payment-summary {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
      color: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">
      <span class="navbar-brand mb-0 h5">Edit Pesanan</span>
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
        <div class="col-md-10">
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
              <h5 class="mb-0 fw-bold">Form Edit Pesanan - {{ $pesanan->resi }}</h5>
            </div>
            <div class="card-body">
              
              @if(session('error'))
              <div class="alert alert-danger">{{ session('error') }}</div>
              @endif

              <form action="{{ route('pesanan.update', $pesanan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Data Pelanggan -->
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="customer_name" class="form-label fw-bold">Nama Pelanggan <span class="text-danger">*</span></label>
                      <input type="text" 
                             class="form-control @error('customer_name') is-invalid @enderror" 
                             id="customer_name" 
                             name="customer_name" 
                             value="{{ old('customer_name', $pesanan->customer_name) }}"
                             required>
                      @error('customer_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="phone" class="form-label fw-bold">Nomor Telepon <span class="text-danger">*</span></label>
                      <input type="text" 
                             class="form-control @error('phone') is-invalid @enderror" 
                             id="phone" 
                             name="phone" 
                             value="{{ old('phone', $pesanan->phone) }}"
                             required>
                      @error('phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="tanggal_pemesanan" class="form-label fw-bold">Tanggal Pemesanan <span class="text-danger">*</span></label>
                      <input type="datetime-local" 
                             class="form-control @error('tanggal_pemesanan') is-invalid @enderror" 
                             id="tanggal_pemesanan" 
                             name="tanggal_pemesanan" 
                             value="{{ old('tanggal_pemesanan', date('Y-m-d\TH:i', strtotime($pesanan->tanggal_pemesanan))) }}"
                             required>
                      @error('tanggal_pemesanan')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                      <select name="status" id="status" class="form-select @error('status') is-invalid @enderror" required>
                        <option value="Menunggu" {{ $pesanan->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                        <option value="Diproses" {{ $pesanan->status == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                        <option value="Selesai" {{ $pesanan->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                        <option value="Diambil" {{ $pesanan->status == 'Diambil' ? 'selected' : '' }}>Diambil</option>
                      </select>
                      @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                  </div>
                </div>

                <hr class="my-4">

                <!-- Layanan -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                  <h6 class="fw-bold mb-0">Layanan <span class="text-danger">*</span></h6>
                  <button type="button" class="btn btn-sm btn-primary" onclick="addLayanan()">
                    <i class="bi bi-plus-circle me-1"></i>Tambah Layanan
                  </button>
                </div>

                <div id="layananContainer">
                  @foreach($pesanan->od as $index => $detail)
                  <div class="layanan-item" data-index="{{ $index }}">
                    <div class="row align-items-end">
                      <div class="col-md-6">
                        <label class="form-label fw-bold">Pilih Layanan</label>
                        <select name="layanan_id[]" class="form-select layanan-select" required onchange="updateHarga(this)">
                          <option value="">-- Pilih Layanan --</option>
                          @foreach($layanans as $layanan)
                          <option value="{{ $layanan->id }}" 
                                  data-harga="{{ $layanan->harga }}"
                                  data-durasi="{{ $layanan->durasi_hari }}"
                                  {{ $detail->layanan_id == $layanan->id ? 'selected' : '' }}>
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
                               value="{{ $detail->berat }}" 
                               required
                               onchange="calculateSubtotal(this)">
                      </div>
                      <div class="col-md-2">
                        <label class="form-label fw-bold">Subtotal</label>
                        <input type="text" class="form-control subtotal-display" readonly value="Rp {{ number_format($detail->subtotal, 0, ',', '.') }}">
                      </div>
                      <div class="col-md-1">
                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeLayanan(this)">
                          <i class="bi bi-trash"></i>
                        </button>
                      </div>
                    </div>
                  </div>
                  @endforeach
                </div>

                <hr class="my-4">

                <!-- Pembayaran -->
                <h6 class="fw-bold mb-3">💰 Informasi Pembayaran</h6>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label for="payment_status" class="form-label fw-bold">Status Pembayaran <span class="text-danger">*</span></label>
                      <select name="payment_status" 
                              id="payment_status" 
                              class="form-select @error('payment_status') is-invalid @enderror" 
                              required
                              onchange="handlePaymentStatusChange()">
                        <option value="Belum Lunas" {{ old('payment_status', $pesanan->payment_status) == 'Belum Lunas' ? 'selected' : '' }}>Belum Lunas</option>
                        <option value="Lunas" {{ old('payment_status', $pesanan->payment_status) == 'Lunas' ? 'selected' : '' }}>Lunas</option>
                      </select>
                      @error('payment_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                      <small class="text-muted">Pilih status pembayaran pesanan</small>
                    </div>

                    <div class="mb-3" id="paidAmountContainer">
                      <label for="paid_amount" class="form-label fw-bold">Jumlah Dibayar</label>
                      <div class="input-group">
                        <span class="input-group-text">Rp</span>
                        <input type="number" 
                               class="form-control @error('paid_amount') is-invalid @enderror" 
                               id="paid_amount" 
                               name="paid_amount" 
                               value="{{ old('paid_amount', $pesanan->paid_amount) }}"
                               min="0"
                               step="0.01"
                               onchange="calculatePaymentDisplay()">
                        @error('paid_amount')
                          <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                      </div>
                      <small class="text-muted">Opsional: Masukkan jumlah yang sudah dibayar</small>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="payment-summary">
                      <div class="d-flex justify-content-between mb-2">
                        <span>Total Tagihan:</span>
                        <strong class="fs-5" id="totalHarga">Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</strong>
                      </div>
                      <div class="d-flex justify-content-between mb-2">
                        <span>Dibayar:</span>
                        <strong id="displayPaidAmount">Rp {{ number_format($pesanan->paid_amount, 0, ',', '.') }}</strong>
                      </div>
                      <hr style="border-color: rgba(255,255,255,0.3);">
                      <div class="d-flex justify-content-between">
                        <span>Sisa Tagihan:</span>
                        <strong class="fs-5" id="sisaTagihan">
                          Rp {{ number_format($pesanan->total_harga - $pesanan->paid_amount, 0, ',', '.') }}
                        </strong>
                      </div>
                      <div class="mt-3">
                        <span class="badge" id="paymentStatusBadge" style="font-size: 14px; padding: 8px 15px;">
                          {{ $pesanan->payment_status }}
                        </span>
                      </div>
                    </div>
                  </div>
                </div>

                <hr class="my-4">

                <div class="d-flex gap-2 mt-4">
                  <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save me-2"></i>Update Pesanan
                  </button>
                  <a href="{{ route('pesanan.show', $pesanan->id) }}" class="btn btn-secondary">
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
  <script>
    let layananIndex = {{ count($pesanan->od) }};

    function addLayanan() {
      const container = document.getElementById('layananContainer');
      const newLayanan = `
        <div class="layanan-item" data-index="${layananIndex}">
          <div class="row align-items-end">
            <div class="col-md-6">
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
      items.forEach((item, index) => {
        const removeBtn = item.querySelector('button[onclick*="removeLayanan"]');
        if (items.length === 1) {
          removeBtn.disabled = true;
        } else {
          removeBtn.disabled = false;
        }
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
      
      // Update display
      document.getElementById('displayPaidAmount').textContent = 'Rp ' + paidAmount.toLocaleString('id-ID');
      document.getElementById('sisaTagihan').textContent = 'Rp ' + sisa.toLocaleString('id-ID');
      
      // Update badge based on dropdown selection
      const badge = document.getElementById('paymentStatusBadge');
      if (paymentStatus === 'Lunas') {
        badge.textContent = 'Lunas ✅';
        badge.className = 'badge bg-success';
      } else {
        badge.textContent = 'Belum Lunas';
        badge.className = 'badge bg-danger';
      }
    }

    // Initialize calculations on page load
    document.addEventListener('DOMContentLoaded', function() {
      updateRemoveButtons();
      calculateTotal();
      calculatePaymentDisplay();
      
      // Add event listener to payment status dropdown
      document.getElementById('payment_status').addEventListener('change', handlePaymentStatusChange);
      
      // Add event listener to paid_amount input
      document.getElementById('paid_amount').addEventListener('input', calculatePaymentDisplay);
    });
  </script>
</body>
</html>