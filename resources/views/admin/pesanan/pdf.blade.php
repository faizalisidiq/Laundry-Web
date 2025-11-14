<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Rekap Pesanan Laundry</title>
    <style>
        @page {
            margin: 15mm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10pt;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin: 0 0 5px 0;
            font-size: 18pt;
            color: #333;
        }
        .header .periode {
            font-size: 12pt;
            color: #666;
            margin: 5px 0;
        }
        .header .info {
            font-size: 9pt;
            color: #888;
            margin-top: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 9pt;
        }
        thead {
            background-color: #ff9d13;
            color: white;
        }
        th {
            padding: 8px 5px;
            text-align: left;
            border: 1px solid #ddd;
            font-weight: bold;
        }
        td {
            padding: 6px 5px;
            border: 1px solid #ddd;
        }
        tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tbody tr:hover {
            background-color: #f0f0f0;
        }
        .text-right { 
            text-align: right; 
        }
        .text-center { 
            text-align: center; 
        }
        .total-row {
            background-color: #ffe5b4 !important;
            font-weight: bold;
            font-size: 10pt;
        }
        .no-data {
            text-align: center;
            padding: 30px;
            color: #999;
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 8pt;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .badge {
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8pt;
            font-weight: bold;
        }
        .badge-success {
            background-color: #d4edda;
            color: #155724;
        }
        .badge-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        .badge-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Berlian Laundry</h1>
        <div class="periode">Rekap Pesanan - {{ $namaBulan }}</div>
        <div class="info">
            Dicetak pada: {{ now()->locale('id')->translatedFormat('l, d F Y - H:i') }} WIT
            @if(isset($filterStatus) && $filterStatus === 'selesai')
                | Filter: Selesai & Lunas
            @else
                | Filter: Semua Status
            @endif
        </div>
    </div>

    @if($orders->isEmpty())
        <div class="no-data">
            <p>📭 Tidak ada data pesanan untuk periode ini</p>
        </div>
    @else
        <table>
            <thead>
                <tr>
                    <th width="4%" class="text-center">No</th>
                    <th width="8%" class="text-center">Resi</th>
                    <th width="15%">Nama Pelanggan</th>
                    <th width="12%">Telepon</th>
                    <th width="20%">Layanan</th>
                    <th width="8%" class="text-center">Status</th>
                    <th width="10%" class="text-center">Pembayaran</th>
                    <th width="10%" class="text-center">Tgl Pesan</th>
                    <th width="13%" class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $index => $order)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="text-center" style="font-weight: bold; color: #666;">{{ $order->resi }}</td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->phone }}</td>
                    <td>
                        @foreach ($order->od as $key => $detail)
                            {{ $detail->layanan->nama_layanan }} ({{ $detail->berat }}kg){{ $key < count($order->od) - 1 ? ', ' : '' }}
                        @endforeach
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $order->status == 'Selesai' ? 'success' : ($order->status == 'Diproses' ? 'warning' : 'danger') }}">
                            {{ $order->status }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge badge-{{ $order->payment_status == 'Lunas' ? 'success' : 'danger' }}">
                            {{ $order->payment_status }}
                        </span>
                    </td>
                    <td class="text-center">{{ \Carbon\Carbon::parse($order->tanggal_pemesanan)->format('d/m/Y') }}</td>
                    <td class="text-right" style="font-weight: bold;">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
                @endforeach
                
                <!-- Total Row -->
                <tr class="total-row">
                    <td colspan="8" class="text-right">TOTAL KESELURUHAN ({{ $orders->count() }} Pesanan):</td>
                    <td class="text-right">Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <!-- Summary Statistics -->
        <div style="margin-top: 20px; padding: 10px; background-color: #f8f9fa; border-radius: 5px;">
            <table style="width: 100%; border: none;">
                <tr style="border: none;">
                    <td style="border: none; padding: 5px;">
                        <strong>Total Pesanan:</strong> {{ $orders->count() }} pesanan
                    </td>
                    <td style="border: none; padding: 5px;">
                        <strong>Total Pendapatan:</strong> Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}
                    </td>
                </tr>
                <tr style="border: none;">
                    <td style="border: none; padding: 5px;">
                        <strong>Status Lunas:</strong> {{ $orders->where('payment_status', 'Lunas')->count() }} pesanan
                    </td>
                    <td style="border: none; padding: 5px;">
                        <strong>Belum Lunas:</strong> {{ $orders->where('payment_status', 'Belum Lunas')->count() }} pesanan
                    </td>
                </tr>
            </table>
        </div>
    @endif

    <div class="footer">
        <p>Dokumen ini dicetak secara otomatis dari Sistem Manajemen Laundry</p>
        <p>Jl. R.E. Martadinata, Nabarua, Distrik Nabire, Kabupaten Nabire, Papua Tengah 98817 | Telp/WA: 6281343047741</p>
    </div>
</body>
</html>
