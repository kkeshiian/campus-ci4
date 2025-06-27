<style>
    @page {
        footer: html_myFooter;
        margin-bottom: 50px;
    }
    body { font-family: sans-serif; font-size: 12pt; }
    .header, .info, .items, .signature { margin-bottom: 20px; }
    .header-logo img { max-height: 80px; }
    .items table, .items th, .items td {
        border: 1px solid black; border-collapse: collapse;
        padding: 6px; text-align: center;
    }
    .items th { background: #eee; }
</style>

<htmlpagefooter name="myFooter">
    <hr>
    <div style="text-align: center; font-size: 10pt;">
        Terima kasih telah menggunakan layanan CampusEats.<br>
        Semoga harimu menyenangkan!
    </div>
</htmlpagefooter>

<div class="header">
    <table width="100%">
        <tr>
            <td width="30%"><img src="<?= FCPATH ?>/campuseats/public/assets/img/logo_campuseats/dummy_campuseats.png" width="100"></td>
            <td align="right">
                <h2>CampusEats</h2>
                <p>Email: campuseats.company@gmail.com | WA: 0851-8989-2516</p>
                <h3>INVOICE</h3>
            </td>
        </tr>
    </table>
</div>

<div class="info">
    <table width="100%">
        <tr>
            <td><strong>Order ID</strong></td><td>: <?= $order_id ?></td>
            <td><strong>Tanggal</strong></td><td>: <?= $tanggal ?></td>
        </tr>
        <tr>
            <td><strong>Nama Pembeli</strong></td><td>: <?= $nama_pembeli ?></td>
            <td><strong>Kantin/Fakultas</strong></td><td>: <?= $nama_kantin ?> (<?= $nama_fakultas ?>)</td>
        </tr>
        <tr>
            <td><strong>Metode Bayar</strong></td><td>: <?= $tipe ?></td>
            <td><strong>Status</strong></td><td>: <?= $status_pembayaran ?></td>
        </tr>
    </table>
</div>

<div class="items">
    <table width="100%">
        <tr>
            <th>No</th>
            <th>Menu</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>Total</th>
        </tr>
            <tr>
                <td>1</td>
                <td><?= $menu ?></td>
                <td><?= $quantity ?></td>
                <td>Rp <?= number_format($harga, 0, ',', '.') ?></td>
                <td>Rp <?= number_format($total, 0, ',', '.') ?></td>
            </tr>
        <tr>
            <td colspan="4" align="right"><strong>Total Bayar</strong></td>
            <td><strong>Rp <?= number_format($total, 0, ',', '.') ?></strong></td>
        </tr>
    </table>
</div>

<div class="signature">
    <p>Tertanda,</p>
    <p><strong>CampusEats Developer</strong></p>
</div>
