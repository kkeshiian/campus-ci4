<?php
if (isset($_GET['id_admin'])) {
    $id_admin = (int) $_GET['id_admin'];
}
require_once '../../middleware/role_auth.php';
require_role('Admin');

include "../../database/koneksi.php";
include "../../database/model.php";
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Notyf CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <title>Dashboard Admin - Manage Report</title>
</head>
<body class="min-h-screen flex flex-col mb-4">
  <?php
  $activePage = 'report';
  include '../../partials/navbar-admin.php'; ?>

  <main class="w-[90%] max-w-10xl mx-auto mt-6">
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
      <h2 class="text-2xl sm:text-3xl font-bold text-black">Manage Problem Report</h2>
    </div>

  <?php
  $ambil_data_user = mysqli_query($koneksi, "SELECT * FROM report");
  ?>

  <div class="overflow-x-auto bg-white border rounded-lg shadow">
    <?php if (mysqli_num_rows($ambil_data_user) == 0) : ?>
      <p class="text-center text-lg p-6 text-gray-600">No user data found.</p>
    <?php else : ?>
      <table class="table w-full text-sm sm:text-base text-center">
        <thead class="bg-kuning text-white">
          <tr>
            <th class="p-2 sm:p-3">No</th>
            <th class="p-2 sm:p-3">ID Report</th>
            <th class="p-2 sm:p-3">Order ID</th>
            <th class="p-2 sm:p-3">Canteen ID</th>
            <th class="p-2 sm:p-3">Canteen Name</th>
            <th class="p-2 sm:p-3">Report Date</th>
            <th class="p-2 sm:p-3">Report Category</th>
            <th class="p-2 sm:p-3">Description Report</th>
            <th class="p-2 sm:p-3">See Report Proof</th>
            <th class="p-2 sm:p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          while ($row_user = mysqli_fetch_assoc($ambil_data_user)) :
          ?>
            <tr class="hover:bg-gray-50">
              <td class="p-2 sm:p-3"><?= $no ?></td>
              <td class="p-2 sm:p-3"><?= htmlspecialchars($row_user['id_report']) ?></td>
              <td class="p-2 sm:p-3"><?= htmlspecialchars($row_user['order_id']) ?></td>
              <td class="p-2 sm:p-3"><?= htmlspecialchars($row_user['id_penjual']) ?></td>
              <td class="p-2 sm:p-3"><?= htmlspecialchars($row_user['nama_kantin']) ?></td>
              <td class="p-2 sm:p-4"><?= htmlspecialchars($row_user['tanggal']) ?></td>
              <td class="p-2 sm:p-3"><?= htmlspecialchars($row_user['kategori']) ?></td>
              <td class="p-2 sm:p-3"><?= htmlspecialchars($row_user['deskripsi']) ?></td>
              <td class="p-2 sm:p-3">
                <?php if (!empty($row_user['bukti'])): ?>
                  <a href="../../assets/<?= htmlspecialchars($row_user['bukti']) ?>" target="_blank" download class="text-blue-600 underline">
                    Download Report Proof
                  </a>
                <?php else: ?>
                  <span class="text-gray-400 italic">No file</span>
                <?php endif; ?>
              </td>

              <td class="p-2 sm:p-3 flex flex-col sm:flex-row justify-center items-center gap-2">
                <a
                  class="btn btn-sm bg-red-500 text-white hover:bg-red-600 transition rounded-lg"
                  onclick="confirmDelete(<?= $row_user['id_report'] ?>, <?= $id_admin ?>)">
                  Delete
                </a>
              </td>
            </tr>
          <?php
          $no++;
          endwhile;
          ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</main>


<script>
  function confirmDelete(id_report, id_admin) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone. The report will be deleted permanently.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e3342f', // merah
      cancelButtonColor: '#FFB43B',
      confirmButtonText: 'Yes, delete'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `hapus_report.php?id_report=${id_report}&id_admin=${id_admin}`;
      }
    });
  }
</script>

<script>
    const notyf = new Notyf({
      duration: 3000,
      position: { x: 'right', y: 'top' },
      types: [
        {
          type: 'success',
          background: '#28a745',
          icon: { className: 'notyf__icon--success', tagName: 'i' }
        }
      ]
    });

    const hapusParam = urlParams.get('hapus');

    if (hapusParam === 'true') {
      notyf.success('Successfully deleted report!');
    } else if (hapusParam === 'false') {
      notyf.error('Failed to delete report!');
    }

    if (hapusParam) {
      history.replaceState(null, '', window.location.pathname);
    }
  </script>
  <script>
  console.log("URL: " + window.location.href);
  console.log("success param: ", new URLSearchParams(window.location.search).get("success"));
</script>
</body>
</html>