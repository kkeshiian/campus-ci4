<?php
if (isset($_GET['id_report']) && ($_GET['id_admin'])) {
    $id_per_report = (int) $_GET['id_report'];
    $id_admin = (int) $_GET['id_admin'];
}

include "../../database/koneksi.php";
include "../../database/model.php";

require_once '../../middleware/role_auth.php';

require_role('Admin');

$hasil = hapusReport($koneksi, $id_per_report, $id_admin);

if ($hasil) {
    header("Location: kelola_report.php?id_admin=$id_admin&hapus=true");
    exit();
} else {
    header("Location: kelola_report.php?id_admin=$id_admin&hapus=false");
    exit();
}
?>