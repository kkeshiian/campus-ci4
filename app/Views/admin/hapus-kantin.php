<?php
if (isset($_GET['id_user']) && ($_GET['id_admin'])) {
    $id_per_penjual = (int) $_GET['id_user'];
    $id_admin = (int) $_GET['id_admin'];
}

include "../../database/koneksi.php";
include "../../database/model.php";

require_once '../../middleware/role_auth.php';

require_role('Admin');

$hasil = hapusPenjual($koneksi, $id_per_penjual, $id_admin);


if ($hasil) {
    // Hapus berhasil, redirect dengan success=true
    header("Location: kelola_kantin.php?id_admin=$id_admin&success=hapus");
    exit();
} else {
    // Hapus gagal, redirect dengan error=true
    header("Location: kelola_kantin.php?id_admin=$id_admin&error=hapus");
    exit();
}

?>