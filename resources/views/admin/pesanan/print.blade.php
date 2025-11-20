<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Struk Laundry - {{ $pesanan->resi }}</title>
  <link href="https://fonts.googleapis.com/css2?family=Courier+Prime:wght@400;700&family=Inconsolata:wght@400;700&display=swap" rel="stylesheet">
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    
    body {
      font-family: 'Courier Prime', 'Consolas', 'Courier New', monospace;
      width: 80mm;
      margin: 0 auto;
      padding: 10px;
      background: white;
      font-weight: 700;
      line-height: 1.2;
      -webkit-font-smoothing: none;
      text-rendering: optimizeSpeed;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
    }
    
    .struk {
      width: 100%;
      border: 3px solid #000;
      padding: 12px;
      background: white;
    }
    
    .header {
      text-align: center;
      margin-bottom: 12px;
      border-bottom: 3px solid #000;
      padding-bottom: 8px;
    }
    
    .header h2 {
      font-size: 20px;
      font-weight: 700;
      margin-bottom: 3px;
      letter-spacing: 0.5px;
    }
    
    .header p {
      font-size: 11px;
      font-weight: 700;
      line-height: 1.3;
      margin: 2px 0;
    }
    
    .section {
      margin: 10px 0;
      font-size: 12px;
      font-weight: 700;
    }
    
    .section-title {
      font-weight: 700;
      font-size: 13px;
      margin-bottom: 6px;
      border-bottom: 2px solid #000;
      padding-bottom: 4px;
      letter-spacing: 0.3px;
    }
    
    .row {
      display: flex;
      justify-content: space-between;
      margin: 4px 0;
      line-height: 1.3;
      font-weight: 700;
      font-size: 12px;
    }
    
    .row.bold {
      font-weight: 700;
      font-size: 13px;
    }
    
    .label {
      flex: 0 0 50%;
      font-weight: 700;
    }
    
    .value {
      flex: 1;
      text-align: right;
      font-weight: 700;
    }
    
    .item-detail {
      margin: 6px 0;
      padding: 6px 0;
      border-bottom: 2px dotted #000;
      font-weight: 700;
    }
    
    .item-name {
      font-weight: 900;
      font-size: 13px;
      margin-bottom: 3px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
    }
    
    .item-calc {
      display: flex;
      justify-content: space-between;
      font-size: 12px;
      font-weight: 700;
      margin-bottom: 2px;
    }

    .item-calc.weight {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      font-weight: 700;
    }

    .item-calc.quantity {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
      font-weight: 700;
    }

    .item-subtotal {
      display: flex;
      justify-content: flex-end;
      font-size: 13px;
      font-weight: 900;
      color: #000;
      margin-top: 2px;
      padding-top: 2px;
      border-top: 1px solid #000;
    }
    
    .total-section {
      margin-top: 10px;
      padding-top: 10px;
      border-top: 3px solid #000;
    }
    
    .total-row {
      display: flex;
      justify-content: space-between;
      margin: 5px 0;
      font-size: 14px;
      font-weight: 700;
    }
    
    .total-row.grand {
      font-weight: 900;
      font-size: 16px;
      margin-top: 8px;
      padding-top: 8px;
      border-top: 2px solid #000;
      letter-spacing: 0.3px;
    }
    
    .payment-info {
      background: #fff;
      padding: 8px;
      margin: 10px 0;
      border: 2px solid #000;
    }
    
    .payment-info .row {
      font-weight: 700;
    }
    
    .footer {
      text-align: center;
      margin-top: 12px;
      padding-top: 10px;
      border-top: 3px solid #000;
      font-size: 11px;
      font-weight: 700;
    }
    
    .footer p {
      margin: 4px 0;
      font-weight: 700;
    }
    
    .footer strong {
      font-weight: 700;
    }
    
    .barcode {
      text-align: center;
      font-size: 26px;
      font-weight: 700;
      letter-spacing: 2px;
      margin: 10px 0;
      padding: 10px;
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
      font-weight: 700;
      border: 2px solid #000;
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
        font-weight: 700;
      }
      
      .struk {
        border: 2px solid #000;
        padding: 10px;
      }

      .print-buttons {
        display: none !important;
      }
      
      @page {
        size: 80mm auto;
        margin: 0;
        padding: 0;
      }

      /* Sangat tebal untuk print */
      * {
        font-weight: 700 !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        color: #000 !important;
      }

      body, .section, .row, .label, .value, .section-title, .item-name, .total-row, .item-calc, .item-subtotal {
        font-weight: 700 !important;
      }

      .header h2, .section-title, .item-name, .total-row.grand, .barcode, .item-subtotal {
        font-weight: 900 !important;
        letter-spacing: 0.5px;
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
      🖨️ Print Struk
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
    </div>

    <!-- Detail Layanan -->
    @if($pesanan->detail_layanan)
    <div class="section">
      <div class="section-title">DETAIL LAYANAN</div>
      @foreach($pesanan->detail_layanan as $detail)
      <div class="item-detail">
        <div class="item-name">{{ strtoupper($detail->layanan->nama_layanan) }}</div>
        <div class="item-calc weight">
          <span>{{ $detail->berat }} Kg × Rp {{ number_format($detail->harga, 0, ',', '.') }}/Kg</span>
          <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
        </div>
        @if($detail->kuantitas > 1)
        <div class="item-calc quantity">
          <span>{{ $detail->kuantitas }} x</span>
          <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
        </div>
        @endif
        <div class="item-subtotal">
          <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
        </div>
      </div>
      @endforeach
    </div>
    @endif

    <!-- Total -->
    <div class="total-section">
      <div class="total-row">
        <span>Subtotal</span>
        <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
      </div>
      <div class="total-row grand">
        <span>TOTAL</span>
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
      <div class="row bold">
        <span class="label">SISA TAGIHAN</span>
        <span class="value">Rp {{ number_format($pesanan->total_harga - $pesanan->paid_amount, 0, ',', '.') }}</span>
      </div>
      @endif
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>═══════════════════</p>
      <p><strong>Cek Status Cucian:</strong></p>
      <p style="font-size: 10px;">{{ route('user.tracking') }}</p>
      <p>═══════════════════</p>
      <p style="margin-top: 8px;">🙏 TERIMA KASIH</p>
      <p><strong>BERLIAN LAUNDRY</strong></p>
      <p style="margin-top: 6px; font-size: 10px;">Dicetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
  </div>


</body>
</html>