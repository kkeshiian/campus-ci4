<?php

include '../../database/koneksi.php';
include '../../database/model.php';

$id_menu    = $_POST['id_menu'];
$id_penjual    = $_POST['id_penjual'];
$nama_menu  = $_POST['nama'];
$harga      = $_POST['harga'];

$gambar_baru = null;

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $gambar_nama = $_FILES['gambar']['name'];
    $gambar_tmp  = $_FILES['gambar']['tmp_name'];
    $ekstensi    = strtolower(pathinfo($gambar_nama, PATHINFO_EXTENSION));

    $ekstensi_valid = ['jpg', 'jpeg', 'png', 'webp'];
    if (in_array($ekstensi, $ekstensi_valid)) {
        $nama_file_baru = uniqid() . '.' . $ekstensi;
        $path_simpan    = '../../assets/' . $nama_file_baru;

        if (move_uploaded_file($gambar_tmp, $path_simpan)) {
            $gambar_baru = $nama_file_baru;
        } else {
            echo "Upload gambar gagal.";
            exit;
        }
    } else {
        echo "Format gambar tidak didukung.";
        exit;
    }
}

$berhasil = updateInfoMenu($koneksi, $id_menu, $nama_menu, $harga, $gambar_baru);
 
if ($berhasil) {
    header("Location: kelola_menu.php?id_menu=$id_menu&id_penjual=$id_penjual&success=true");
    exit;
} else {
    echo "Gagal update menu.";
}
