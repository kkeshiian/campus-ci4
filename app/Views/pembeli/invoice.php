<?php
require_once __DIR__ . '/../../vendor/autoload.php'; // pakai Composer autoload modern

include '../../database/koneksi.php';
include '../../database/model.php';

use Mpdf\Mpdf;

$order_id = $_GET['order_id'] ?? '';

if (!$order_id) {
    die("Order ID tidak valid.");
}

$query = "SELECT * FROM riwayat_pembelian 
          JOIN pembeli ON riwayat_pembelian.id_pembeli = pembeli.id_pembeli 
          JOIN user ON pembeli.id_user = user.id_user
          WHERE order_id = '$order_id'";
$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) == 0) {
    die("Data tidak ditemukan.");
}

$items = [];
$total = 0;
$row = mysqli_fetch_assoc($result);
$nama_pembeli = $row['nama'];
$tanggal = $row['tanggal'];
$tipe = $row['tipe'];
$status_bayar = $row['status_pembayaran'];
$nama_kantin = $row['nama_kantin'];

$ambil_id_fakultas = mysqli_query($koneksi, "SELECT id_fakultas FROM penjual WHERE nama_kantin='$nama_kantin'");
$id_fakultas_result = mysqli_fetch_assoc($ambil_id_fakultas);
$id_fakultas = $id_fakultas_result['id_fakultas'];

$ambil_nama_fakultas = mysqli_query($koneksi, "SELECT nama_fakultas FROM fakultas WHERE id_fakultas='$id_fakultas'");
$nama_fakultas_result = mysqli_fetch_assoc($ambil_nama_fakultas);
$nama_fakultas = $nama_fakultas_result['nama_fakultas'];

mysqli_data_seek($result, 0);

while ($data = mysqli_fetch_assoc($result)) {
    $items[] = $data;
    $total += $data['total'];
}

$html = '
<style>
    @page {
        footer: html_myFooter;
        margin-bottom: 50px;
    }
    body { font-family: sans-serif; font-size: 12pt; }
    .header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .header-logo {
        width: 100px;
        flex-shrink: 0;
    }

    .header-logo img {
        display: block;
        max-height: 80px;
        object-fit: contain;
    }

    .header-title {
        text-align: right;
        flex-grow: 1;
    }

    .header-title h2 {
        margin: 0;
    }

    .header-title p {
        font-size: 7pt;
        margin: 4px 0;
    }

    .info, .footer { margin: 20px 0; }
    .info table { width: 100%; }
    .info td { padding: 4px 8px; vertical-align: top; }
    .items table { width: 100%; border-collapse: collapse; }
    .items th, .items td { border: 1px solid #000; padding: 8px; text-align: center; }
    .items th { background-color: #f2f2f2; }
    .signature { margin-top: 60px; text-align: left; }
    .signature p { margin-bottom: 60px; }
</style>

<htmlpagefooter name="myFooter">
    <hr>
    <div class="footer" style="text-align: center; font-size: 10pt;">
        Terima kasih telah menggunakan layanan CampusEats.<br>
        Semoga harimu menyenangkan!
    </div>
</htmlpagefooter>

<div class="header">
    <div class="header-logo">
        <img src="/campuseats/assets/img/logo_campuseats/dummy_campuseats.png" width="100">
    </div>
    <div class="header-title">
        <h2>CampusEats</h2>
        <p>Order fast, pay cashless, and skip the lines.</p>
        <p>Email: campuseats.company@gmail.com | WA: 0851-8989-2516</p>
        <h3>INVOICE</h3>
    </div>
</div>


<hr>

<div class="info">
    <table>
        <tr>
            <td><strong>Order ID</strong></td><td>: ' . $order_id . '</td>
            <td><strong>Tanggal</strong></td><td>: ' . $tanggal . '</td>
        </tr>
        <tr>
            <td><strong>Nama Pembeli</strong></td><td>: ' . $nama_pembeli . '</td>
            <td><strong>Kantin/Fakultas</strong></td><td>: ' . $nama_kantin . ' (Fakultas ' . $nama_fakultas . ')</td>
        </tr>
        <tr>
            <td><strong>Metode Bayar</strong></td><td>: ' . $tipe . '</td>
            <td><strong>Status</strong></td><td>: ' . $status_bayar . '</td>
        </tr>
    </table>
</div>

<div class="items">
    <table>
        <tr>
            <th>No</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Total</th>
        </tr>';

$no = 1;
foreach ($items as $item) {
    $harga_satuan = $item['total'] / $item['quantity'];
    $html .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $item['menu'] . '</td>
            <td>' . $item['quantity'] . '</td>
            <td>Rp ' . number_format($harga_satuan, 0, ',', '.') . '</td>
            <td>Rp ' . number_format($item['total'], 0, ',', '.') . '</td>
        </tr>';
}

$html .= '
        <tr>
            <td colspan="4" style="text-align: right;"><strong>Total Bayar</strong></td>
            <td><strong>Rp ' . number_format($total, 0, ',', '.') . '</strong></td>
        </tr>
    </table>
</div>

<div class="signature">
    <p>Tertanda,</p>
    <p><strong>CampusEats Developer</strong></p>
</div>
';



$mpdf = new Mpdf(); //
$mpdf->WriteHTML($html);
$mpdf->Output("Invoice_$order_id.pdf", "D");
?>
