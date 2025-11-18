<?php
namespace App\Http\Controllers;
use Mike42\Escpos\Printer;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
// Jika pakai LAN: use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
// Jika pakai USB php-windows: use Mike42\Escpos\PrintConnectors\UsbPrintConnector;

public function printThermal($id)
{
    $pesanan = Order::with(['od.layanan', 'user'])->findOrFail($id);

    // --- GANTI nama printer sesuai Windows ---
    $connector = new WindowsPrintConnector("POS-80"); 
    // Jika pakai jaringan:
    // $connector = new NetworkPrintConnector("192.168.1.50", 9100);

    $printer = new Printer($connector);

    /* --------------------------
     *        HEADER
     * -------------------------- */
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH | Printer::MODE_EMPHASIZED);
    $printer->text("BERLIAN LAUNDRY\n");
    $printer->selectPrintMode();
    $printer->text("Jl. R.E. Martadinata, Nabarua\n");
    $printer->text("Distrik Nabire, Kab. Nabire\n");
    $printer->text("Papua Tengah 98817\n");
    $printer->text("Telp/WA: +62 813-4304-7741\n");
    $printer->text("--------------------------------\n");


    /* --------------------------
     *           BARCODE
     * -------------------------- */
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->setBarcodeHeight(60);
    $printer->setBarcodeWidth(2);
    $printer->barcode($pesanan->resi, Printer::BARCODE_CODE39);
    $printer->text("#{$pesanan->resi}\n");
    $printer->text("--------------------------------\n");


    /* --------------------------
     *      INFORMASI PESANAN
     * -------------------------- */
    $printer->setJustification(Printer::JUSTIFY_LEFT);
    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
    $printer->text("INFORMASI PESANAN\n");
    $printer->selectPrintMode();
    $printer->text("--------------------------------\n");

    $printer->text("Pelanggan : " . $pesanan->customer_name . "\n");
    $printer->text("Telepon   : " . $pesanan->phone . "\n");
    $printer->text("Masuk     : " . \Carbon\Carbon::parse($pesanan->tanggal_pemesanan)->format('d/m/Y H:i') . "\n");
    $printer->text("Selesai   : " . \Carbon\Carbon::parse($pesanan->tanggal_selesai)->format('d/m/Y H:i') . "\n");
    $printer->text("Kasir     : " . $pesanan->user->name . "\n");
    $printer->text("--------------------------------\n");


    /* --------------------------
     *      DETAIL LAYANAN
     * -------------------------- */
    $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
    $printer->text("DETAIL LAYANAN\n");
    $printer->selectPrintMode();
    $printer->text("--------------------------------\n");

    foreach ($pesanan->od as $d) {
        $printer->selectPrintMode(Printer::MODE_EMPHASIZED);
        $printer->text(strtoupper($d->layanan->nama_layanan) . "\n");
        $printer->selectPrintMode();

        $line = $d->berat . " Kg × " . number_format($d->harga, 0, ',', '.');
        $subtotal = "Rp " . number_format($d->subtotal, 0, ',', '.');

        // Align kanan untuk subtotal
        $printer->text($this->leftRight($line, $subtotal));
    }

    $printer->text("--------------------------------\n");


    /* --------------------------
     *           TOTAL
     * -------------------------- */
    $printer->selectPrintMode(Printer::MODE_DOUBLE_WIDTH | Printer::MODE_EMPHASIZED);
    $total = "Rp " . number_format($pesanan->total_harga, 0, ',', '.');
    $printer->text($this->leftRight("TOTAL TAGIHAN", $total));
    $printer->selectPrintMode();
    $printer->text("--------------------------------\n");


    /* --------------------------
     *      PAYMENT INFO
     * -------------------------- */
    $printer->text("Status Bayar : " . strtoupper($pesanan->payment_status) . "\n");
    $printer->text("Dibayar      : Rp " . number_format($pesanan->paid_amount, 0, ',', '.') . "\n");

    if ($pesanan->payment_status == 'Belum Lunas') {
        $sisa = $pesanan->total_harga - $pesanan->paid_amount;
        $printer->text("Sisa         : Rp " . number_format($sisa, 0, ',', '.') . "\n");
    }

    $printer->text("--------------------------------\n");


    /* --------------------------
     *            FOOTER
     * -------------------------- */
    $printer->setJustification(Printer::JUSTIFY_CENTER);
    $printer->text("Cek status cucian:\n");
    $printer->text(route('user.tracking') . "\n");
    $printer->text("════════════════════════════\n");
    $printer->text("🙏 TERIMA KASIH\n");
    $printer->text("BERLIAN LAUNDRY\n");
    $printer->text("Dicetak: " . now()->format('d/m/Y H:i') . "\n");

    /* End */
    $printer->feed(4);
    $printer->cut();
    $printer->close();

    return back()->with("success", "Struk berhasil dicetak");
}


// Fungsi tambahan untuk rata kiri-kanan
private function leftRight($left, $right, $width = 32)
{
    $spaces = $width - strlen($left) - strlen($right);
    return $left . str_repeat(" ", max($spaces, 0)) . $right . "\n";
}
