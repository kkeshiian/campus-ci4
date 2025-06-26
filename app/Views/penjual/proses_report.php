<?php
include '../../database/koneksi.php';
include '../../database/model.php';

$id_penjual = $_POST['id_penjual'];
$nama_kantin = $_POST['nama_kantin'];
$tanggal = $_POST['tanggal'];
$kategori = $_POST['kategori'];
$order_id = $_POST['order_id'];
$deskripsi = $_POST['deskripsi'];
$id_fakultas = $_POST['id_fakultas'];

$tarik_id_pembeli = mysqli_query($koneksi, "SELECT id_pembeli FROM riwayat_pembelian WHERE order_id='$order_id'");
$data_id_pembeli = mysqli_fetch_assoc($tarik_id_pembeli);
$id_pembeli=$data_id_pembeli['id_pembeli'];

$foto_bukti = null;

if (isset($_FILES['bukti']) && $_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
    $nama_file = $_FILES['bukti']['name'];
    $tmp_file = $_FILES['bukti']['tmp_name'];
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    if (in_array($ext, $allowed_ext)) {
        $new_filename = uniqid() . '.' . $ext;
        $destination = '../../assets/' . $new_filename;

        if (move_uploaded_file($tmp_file, $destination)) {
            $foto_bukti = $new_filename;
        } else {
            echo "Upload foto bukti gagal.";
            exit;
        }
    } else {
        echo "Format foto bukti tidak didukung.";
        exit;
    }
}


$berhasil = submitReport($koneksi, $id_penjual, $id_pembeli, $order_id, 
$nama_kantin, $tanggal, $kategori, $deskripsi, $foto_bukti);

if ($berhasil) {
    header("Location: report_problem.php?id_penjual=" . $id_penjual . "&success=true");
    exit;
} else {
    echo "Failed to submit report.";
}
