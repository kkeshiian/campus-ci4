<?php
include '../../database/koneksi.php';
include '../../database/model.php';

$id_pembeli = $_POST['id_pembeli'];
$nama = $_POST['nama'];
$email = $_POST['email'];
$nomor_wa = $_POST['nomor_wa'];

$foto_baru = null;

if (isset($_FILES['foto_user']) && $_FILES['foto_user']['error'] === UPLOAD_ERR_OK) {
    $nama_file = $_FILES['foto_user']['name'];
    $tmp_file = $_FILES['foto_user']['tmp_name'];
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
$hasil = updateInfoPembeli($koneksi, $id_pembeli, $nama, $email, $nomor_wa, $foto_baru);

if (strpos($hasil, 'success:') === 0) {
    header("Location: profile.php?id_pembeli=" . $id_pembeli . "&success=true");
    exit;
} else {
    $pesan_error = substr($hasil, 6); // potong "error:"
    echo "<script>alert('$pesan_error'); window.history.back();</script>";
}