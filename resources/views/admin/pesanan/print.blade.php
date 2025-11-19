<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk Laundry - {{ $pesanan->resi }}</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Courier New', 'Consolas', monospace;
      width: 80mm;
      margin: 0 auto;
      padding: 10px;
      background: white;
      font-weight: 900;
      -webkit-font-smoothing: none;
      text-rendering: optimizeSpeed;
    }
    
    .struk {
      width: 100%;
      border: 3px dashed #000;
      padding: 15px;
    }
    
    .header {
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 3px solid #000;
      padding-bottom: 10px;
    }
    
    .header h2 {
      font-size: 22px;
      font-weight: 900;
      margin-bottom: 5px;
      letter-spacing: 1px;
    }
    
    .header p {
      font-size: 12px;
      font-weight: 900;
      line-height: 1.6;
      margin: 2px 0;
    }
    
    .section {
      margin: 12px 0;
      font-size: 13px;
      font-weight: 900;
    }
    
    .section-title {
      font-weight: 900;
      font-size: 14px;
      margin-bottom: 8px;
      border-bottom: 2px solid #000;
      padding-bottom: 5px;
      letter-spacing: 0.5px;
    }
    
    .row {
      display: flex;
      justify-content: space-between;
      margin: 5px 0;
      line-height: 1.6;
      font-weight: 900;
    }
    
    .row.bold {
      font-weight: 900;
      font-size: 14px;
    }
    
    .label {
      flex: 0 0 45%;
      font-weight: 900;
    }
    
    .value {
      flex: 1;
      text-align: right;
      font-weight: 900;
    }
    
    .item-detail {
      margin: 8px 0;
      padding: 8px 0;
      border-bottom: 2px dotted #000;
    }
    
    .item-name {
      font-weight: 900;
      font-size: 14px;
      margin-bottom: 4px;
    }
    
    .item-calc {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      font-weight: 900;
    }
    
    .total-section {
      margin-top: 12px;
      padding-top: 12px;
      border-top: 3px solid #000;
    }
    
    .total-row {
      display: flex;
      justify-content: space-between;
      margin: 6px 0;
      font-size: 15px;
      font-weight: 900;
    }
    
    .total-row.grand {
      font-weight: 900;
      font-size: 18px;
      margin-top: 10px;
      padding-top: 10px;
      border-top: 2px dashed #000;
      letter-spacing: 0.5px;
    }
    
    .payment-info {
      background: #f0f0f0;
      padding: 10px;
      margin: 12px 0;
      border: 2px solid #000;
    }
    
    .payment-info .row {
      font-weight: 900;
    }
    
    .footer {
      text-align: center;
      margin-top: 15px;
      padding-top: 12px;
      border-top: 3px solid #000;
      font-size: 12px;
      font-weight: 900;
    }
    
    .footer p {
      margin: 5px 0;
      font-weight: 900;
    }
    
    .footer strong {
      font-weight: 900;
    }
    
    .barcode {
      text-align: center;
      font-size: 28px;
      font-weight: 900;
      letter-spacing: 3px;
      margin: 12px 0;
      padding: 12px;
      border: 3px solid #000;
      background: #fff;
    }

    /* Print button styles */
    .print-buttons {
      text-align: center;
      margin: 20px 0;
      padding: 15px;
      background: #f8f9fa;
      border-radius: 8px;
    }

    .print-btn {
      padding: 12px 30px;
      margin: 5px;
      font-size: 16px;
      font-weight: 900;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: all 0.3s;
    }

    .print-btn.primary {
      background: #0d6efd;
      color: white;
    }

    .print-btn.primary:hover {
      background: #0b5ed7;
      transform: scale(1.05);
    }

    .print-btn.secondary {
      background: #6c757d;
      color: white;
    }

    .print-btn.secondary:hover {
      background: #5a6268;
    }

    .print-btn.success {
      background: #198754;
      color: white;
    }

    .print-btn.success:hover {
      background: #157347;
    }
    
    @media print {
      body {
        width: 80mm;
        margin: 0;
        padding: 0;
      }
      
      .struk {
        border: none;
        padding: 10px;
      }

      .print-buttons {
        display: none !important;
      }
      
      @page {
        size: 80mm auto;
        margin: 0;
      }

      /* Extra tebal untuk print */
      body, .section, .row, .label, .value {
        font-weight: 900 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
      }

      .header h2, .section-title, .item-name, .total-row.grand {
        font-weight: 900 !important;
        text-shadow: 0.5px 0.5px 0 #000;
      }
    }
    
    @media screen {
      body {
        background: #e9ecef;
        padding: 20px;
      }
    }
  </style>
</head>
<body>
  <!-- Print Buttons (Hidden saat print) -->
  <div class="print-buttons">
    <button class="print-btn primary" onclick="window.print()">
      🖨️ Print Struk (Printer Biasa)
    </button>
    <button class="print-btn success" onclick="printThermal()">
      📄 Print Thermal
    </button>
    <button class="print-btn secondary" onclick="window.close()">
      ❌ Tutup
    </button>
  </div>

  <div class="struk">
    <!-- Header -->
    <div class="header">
      <h2>🧺 BERLIAN LAUNDRY</h2>
      <p>Jl. R.E. Martadinata, Nabarua</p>
      <p>Distrik Nabire, Kab. Nabire</p>
      <p>Papua Tengah 98817</p>
      <p>Telp/WA: +62 813-4304-7741</p>
    </div>

    <!-- Barcode/Resi -->
    <div class="barcode">
      #{{ $pesanan->resi }}
    </div>

    <!-- Info Pesanan -->
    <div class="section">
      <div class="section-title">INFORMASI PESANAN</div>
      <div class="row bold">
        <span class="label">Pelanggan</span>
        <span class="value">{{ $pesanan->customer_name }}</span>
      </div>
      <div class="row">
        <span class="label">Telepon</span>
        <span class="value">{{ $pesanan->phone }}</span>
      </div>
      <div class="row">
        <span class="label">Tanggal Masuk</span>
        <span class="value">{{ \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d/m/Y H:i') }}</span>
      </div>
      <div class="row bold">
        <span class="label">Est. Selesai</span>
        <span class="value">{{ \Carbon\Carbon::parse($pesanan->tanggal_selesai)->format('d/m/Y H:i') }}</span>
      </div>
      <div class="row">
        <span class="label">Kasir</span>
        <span class="value">{{ $pesanan->user->name }}</span>
      </div>
    </div>

    <!-- Total -->
    <div class="total-section">
      <div class="total-row grand">
        <span>TOTAL TAGIHAN</span>
        <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
      </div>
    </div>

    <!-- Payment Info -->
    <div class="payment-info">
      <div class="row bold">
        <span class="label">Status Bayar</span>
        <span class="value">{{ strtoupper($pesanan->payment_status) }}</span>
      </div>
      <div class="row">
        <span class="label">Dibayar</span>
        <span class="value">Rp {{ number_format($pesanan->paid_amount, 0, ',', '.') }}</span>
      </div>
      @if($pesanan->payment_status == 'Belum Lunas')
      <div class="row bold" style="color: #dc3545;">
        <span class="label">SISA TAGIHAN</span>
        <span class="value">Rp {{ number_format($pesanan->total_harga - $pesanan->paid_amount, 0, ',', '.') }}</span>
      </div>
      @endif
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>═════════════════════</p>
      <p><strong>Cek Status Cucian:</strong></p>
      <p style="font-size: 11px;">{{ route('user.tracking') }}</p>
      <p>═════════════════════</p>
      <p style="margin-top: 10px; font-weight: 900;">🙏 TERIMA KASIH</p>
      <p><strong>BERLIAN LAUNDRY</strong></p>
      <p style="margin-top: 8px; font-size: 10px; font-weight: 900;">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
  </div>

  <script>
    // Function untuk print thermal (ESC/POS)
    function printThermal() {
      // Cek apakah browser support Web Bluetooth API
      if (!navigator.bluetooth) {
        alert('Browser Anda tidak mendukung Web Bluetooth. Gunakan Chrome/Edge terbaru.');
        return;
      }

      alert('Fitur print thermal memerlukan printer bluetooth yang support ESC/POS.\n\nUntuk saat ini, silakan gunakan Print Struk biasa atau screenshot struk ini.');
      
      // Alternatif: auto print biasa
      window.print();
    }

    // Optional: Auto print on load (comment jika tidak mau auto print)
    // window.onload = function() {
    //   setTimeout(() => window.print(), 500);
    // }
  </script>
</body>
</html>