<?php
include '../../database/koneksi.php';
include '../../database/model.php';

$nama_menu = $_POST['nama'];
$harga = $_POST['harga'];
$id_penjual = $_POST['id_penjual'];
$gambar_baru = null;

if (!$nama_menu || !$harga) {
    echo "Data tidak lengkap.";
    exit;
}

if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
    $nama_file = $_FILES['gambar']['name'];
    $tmp_file = $_FILES['gambar']['tmp_name'];
    $ext = strtolower(pathinfo($nama_file, PATHINFO_EXTENSION));

    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];

    if (in_array($ext, $allowed_ext)) {
        $nama_file_baru = uniqid() . '.' . $ext;
        $path_simpan = '../../assets/' . $nama_file_baru;

        if (move_uploaded_file($tmp_file, $path_simpan)) {
            $gambar_baru = 'assets/' . $nama_file_baru;
        } else {
            $gambar_baru = 'assets/default-menu.jpg';
        }
    } else {
        $gambar_baru = 'assets/default-menu.jpg';
    }
} else {
    $gambar_baru = 'assets/default-menu.jpg';
}

$berhasil = tambahMenu($koneksi, $id_penjual, $nama_menu, $harga, $gambar_baru);

if ($berhasil) {
    header("Location: kelola_menu.php?id_penjual=$id_penjual&success=tambah");
    exit;
} else {
    echo "Gagal menambah menu.";
    echo "<br>Error: " . mysqli_error($koneksi); 
}
