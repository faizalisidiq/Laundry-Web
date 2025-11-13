<!DOCTYPE html>
<html>
<head>
    <title>Daftar Peserta PDF</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px 8px;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
            text-align: left;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h1>Rekap Pesanan Laundry</h1>
    <p><strong>Periode: {{ $namaBulan ?? now()->locale('id')->translatedFormat('F Y') }}</strong></p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Telepon</th>
                <th>Layanan</th>
                <th>Status</th>
                <th>Pembayaran</th>
                <th>Tanggal Pesan</th>
                <th>Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $index => $order)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->phone }}</td>
                <td>
                    @foreach ($order->od as $detail)
                        {{ $detail->layanan->nama_layanan }}
                    @endforeach
                </td>
                <td>{{ $order->status }}</td>
                <td>{{ $order->payment_status }}</td>
                <td>{{ \Carbon\Carbon::parse($order->tanggal_pemesanan)->format('d/m/Y') }}</td>
                <td class="text-right">{{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
            <tr class="total-row">
                <td colspan="7" class="text-right"><strong>TOTAL KESELURUHAN:</strong></td>
                <td class="text-right"><strong>Rp {{ number_format($orders->sum('total_harga'), 0, ',', '.') }}</strong></td>
            </tr>
        </tbody>
    </table>
</body>
</html>
