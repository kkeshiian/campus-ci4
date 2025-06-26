<?php
if (isset($_GET['id_menu'])) {
    $id_per_menu = (int) $_GET['id_menu'];
}else{
  header("Location: /campuseats/pages/auth/logout.php");
  exit();
}

if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
}else{
  header("Location: /campuseats/pages/auth/logout.php");
  exit();
}

include "../../database/koneksi.php";
include "../../database/model.php";

require_once '../../middleware/role_auth.php'; 

require_role('penjual');

$result = hapusMenu($koneksi, $id_per_menu, $id_per_penjual);

if ($result) {
    // Hapus berhasil, redirect dengan success=true
    header("Location: kelola_menu.php?id_penjual=$id_per_penjual&success=hapus");
    exit();
} else {
    // Hapus gagal, redirect dengan error=true
    header("Location: kelola_menu.php?id_penjual=$id_per_penjual&error=hapus");
    exit();
}
?>