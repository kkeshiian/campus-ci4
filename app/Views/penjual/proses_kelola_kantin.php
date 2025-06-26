<?php
include '../../database/koneksi.php';
include '../../database/model.php';

$id_penjual = $_POST['id_penjual'];
$nama_kantin = $_POST['nama_kantin'];
$link = $_POST['link'];
$id_fakultas = $_POST['id_fakultas'];


$foto_baru = null;

if (isset($_FILES['foto_kantin']) && $_FILES['foto_kantin']['error'] === UPLOAD_ERR_OK) {
    $nama_file = $_FILES['foto_kantin']['name'];
    $tmp_file = $_FILES['foto_kantin']['tmp_name'];
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    if (in_array($ext, $allowed_ext)) {
        $new_filename = uniqid() . '.' . $ext;
        $destination = '../../assets/' . $new_filename;

        if (move_uploaded_file($tmp_file, $destination)) {
            $foto_baru = $new_filename;
        } else {
            echo "Upload foto kantin gagal.";
            exit;
        }
    } else {
        echo "Format foto kantin tidak didukung.";
        exit;
    }
}
$berhasil = updateInfoKantin($koneksi, $id_penjual, $nama_kantin, $link, $id_fakultas, $foto_baru);

if ($berhasil) {
    header("Location: kelola_kantin.php?id_penjual=" . $id_penjual . "&success=true");
    exit;
} else {
    echo "Gagal update data kantin.";
}
