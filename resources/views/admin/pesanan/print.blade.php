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
      font-family: 'Courier New', monospace;
      width: 80mm;
      margin: 0 auto;
      padding: 10px;
      background: white;
    }
    
    .struk {
      width: 100%;
      border: 2px dashed #000;
      padding: 15px;
    }
    
    .header {
      text-align: center;
      margin-bottom: 15px;
      border-bottom: 2px solid #000;
      padding-bottom: 10px;
    }
    
    .header h2 {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 5px;
    }
    
    .header p {
      font-size: 11px;
      line-height: 1.4;
      margin: 2px 0;
    }
    
    .section {
      margin: 10px 0;
      font-size: 12px;
    }
    
    .section-title {
      font-weight: bold;
      margin-bottom: 5px;
      border-bottom: 1px solid #000;
      padding-bottom: 3px;
    }
    
    .row {
      display: flex;
      justify-content: space-between;
      margin: 3px 0;
      line-height: 1.4;
    }
    
    .row.bold {
      font-weight: bold;
    }
    
    .label {
      flex: 0 0 45%;
    }
    
    .value {
      flex: 1;
      text-align: right;
    }
    
    .item-detail {
      margin: 5px 0;
      padding: 5px 0;
      border-bottom: 1px dotted #ccc;
    }
    
    .item-name {
      font-weight: bold;
      margin-bottom: 2px;
    }
    
    .item-calc {
      display: flex;
      justify-content: space-between;
      font-size: 11px;
    }
    
    .total-section {
      margin-top: 10px;
      padding-top: 10px;
      border-top: 2px solid #000;
    }
    
    .total-row {
      display: flex;
      justify-content: space-between;
      margin: 5px 0;
      font-size: 14px;
    }
    
    .total-row.grand {
      font-weight: bold;
      font-size: 16px;
      margin-top: 8px;
      padding-top: 8px;
      border-top: 1px dashed #000;
    }
    
    .payment-info {
      background: #f5f5f5;
      padding: 8px;
      margin: 10px 0;
      border: 1px solid #ddd;
    }
    
    .footer {
      text-align: center;
      margin-top: 15px;
      padding-top: 10px;
      border-top: 2px solid #000;
      font-size: 11px;
    }
    
    .footer p {
      margin: 3px 0;
    }
    
    .barcode {
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      letter-spacing: 2px;
      margin: 10px 0;
      padding: 10px;
      border: 2px solid #000;
      background: #fff;
    }
    
    @media print {
      body {
        width: 80mm;
      }
      
      .struk {
        border: none;
      }
      
      @page {
        size: 80mm auto;
        margin: 0;
      }
    }
  </style>
</head>
<body>
  <div class="struk">
    <!-- Header -->
    <div class="header">
      <h2>🧺 BERLIAN LAUNDRY</h2>
      <p>Jl. R.E. Martadinata, Nabarua, Distrik Nabire, Kabupaten Nabire, Papua Tengah 98817</p>
      <p>Telp/WA: +62 81343047741</p>
    </div>

    <!-- Barcode/Resi -->
    <div class="barcode">
      {{ $pesanan->resi }}
    </div>

    <!-- Info Pesanan -->
    <div class="section">
      <div class="section-title">INFORMASI PESANAN</div>
      <div class="row">
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
      <div class="row">
        <span class="label">Estimasi Selesai</span>
        <span class="value">{{ \Carbon\Carbon::parse($pesanan->tanggal_selesai)->format('d/m/Y H:i') }}</span>
      </div>
      <div class="row">
        <span class="label">Kasir</span>
        <span class="value">{{ $pesanan->user->name }}</span>
      </div>
    </div>

    <!-- Detail Layanan -->
    <div class="section">
      <div class="section-title">DETAIL LAYANAN</div>
      @foreach($pesanan->od as $detail)
      <div class="item-detail">
        <div class="item-name">{{ $detail->layanan->nama_layanan }}</div>
        <div class="item-calc">
          <span>{{ $detail->berat }} Kg × Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
          <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
        </div>
      </div>
      @endforeach
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
        <span class="label">Status Pembayaran</span>
        <span class="value">{{ $pesanan->payment_status }}</span>
      </div>
      @if($pesanan->payment_status == 'Belum Lunas')
      <div class="row">
        <span class="label">Dibayar</span>
        <span class="value">Rp {{ number_format($pesanan->paid_amount, 0, ',', '.') }}</span>
      </div>
      <div class="row bold">
        <span class="label">Sisa Tagihan</span>
        <span class="value">Rp {{ number_format($pesanan->total_harga - $pesanan->paid_amount, 0, ',', '.') }}</span>
      </div>
      @else
      <div class="row">
        <span class="label">Dibayar</span>
        <span class="value">Rp {{ number_format($pesanan->paid_amount, 0, ',', '.') }}</span>
      </div>
      @endif
    </div>

    <!-- Footer -->
    <div class="footer">
      <p>═══════════════════════════</p>
      <p><strong>Pantau Status Cucian Anda:</strong></p>
      <p>{{ route('user.tracking') }}</p>
      <p>═══════════════════════════</p>
      <p style="margin-top: 10px;">🙏 Terima kasih sudah menggunakan</p>
      <p><strong>layanan Berlian Laundry</strong></p>
      <p style="margin-top: 10px; font-size: 10px;">Dicetak: {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
  </div>

  <script>
    // Auto print on load
    window.onload = function() {
      window.print();
    }
  </script>
</body>
</html>