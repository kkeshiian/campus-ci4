<?php
if (isset($_GET['id_penjual'])) {
    $id_per_penjual = (int) $_GET['id_penjual'];
} else {
    header("Location: /campuseats/pages/auth/logout.php");
    exit();
}

include "../../database/koneksi.php";
include "../../database/model.php";
require_once '../../middleware/role_auth.php';

require_role('penjual');
?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>Report Problem</title>

  <!-- AOS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <!-- Notyf -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
</head>
<body class="min-h-screen flex flex-col">
  <?php 
  $activePage = 'report_problem';
  include '../../partials/navbar-penjual.php'; ?>
  <?php $gambar_kantin_default = "/campuseats/assets/img/default-canteen.jpg"; ?>

  <main class="w-[90%] mx-auto mt-6 max-w-5xl mb-4" data-aos="fade-up" data-aos-duration="1000">
    <h2 class="text-2xl font-bold mb-4" data-aos="fade-right" data-aos-duration="1000">Report Your Problem</h2>

    <form action="proses_report.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow border border-black flex flex-col min-h-[600px]">
      <?php
        $ambil_data = mysqli_query($koneksi, "
        SELECT penjual.nama_kantin, penjual.link, penjual.gambar, fakultas.nama_fakultas, fakultas.id_fakultas 
        FROM penjual 
        JOIN fakultas ON penjual.id_fakultas = fakultas.id_fakultas 
        WHERE penjual.id_penjual='$id_per_penjual'");
        $data = mysqli_fetch_assoc($ambil_data);
        $queryFakultas = mysqli_query($koneksi, "SELECT id_fakultas, nama_fakultas FROM fakultas ORDER BY nama_fakultas ASC");
        $id_fakultas_terpilih = $data['id_fakultas'];
      ?>

      <div class="flex flex-col md:flex-row gap-6 flex-1">
        <input type="hidden" name="id_penjual" value="<?= $id_per_penjual ?>" />
        <input type="hidden" name="nama_kantin" value="<?= $data['nama_kantin'] ?>" />
        <div class="flex flex-col md:flex-row gap-4 flex-1">
          <div class="flex-1">
            <div class="mb-4">
              <label class="block font-semibold mb-1">Canteen Name</label>
              <input type="text" disabled name="nama_kantin" value="<?= htmlspecialchars($data['nama_kantin']) ?>" class="input input-bordered w-full" />
            </div>
            <div class="mb-4">
              <label class="block font-semibold mb-1">Canteen ID</label>
              <input type="text" disabled name="id_penjual" value="<?= htmlspecialchars($id_per_penjual) ?>" class="input input-bordered w-full" />
            </div>
            <div class="mb-4">
              <label class="block font-semibold mb-1">Report Date</label>
              <input type="date" name="tanggal" class="input input-bordered w-full" required />
            </div>
            <div class="mb-4">
              <label class="block font-semibold mb-1">Report Category</label>
              <select name="kategori" class="select select-bordered w-full" required>
                <option value="">-- Select Your Problem Category --</option>
                <option value="Technical Issue">Technical Issue</option>
                <option value="Customer Complaint">Buyer Complain</option>
                <option value="Order Issue">Wrong Order</option>
                <option value="Order Issue">Payment Issue</option>
                <option value="Other">Others</option>
              </select>
            </div>
            <div class="mb-4">
              <label class="block font-semibold mb-1">Order ID</label>
              <select name="order_id" class="select select-bordered w-full" required>
                <option value="">-- Select Your Order ID --</option>
                <?php
                  $ambil_data_order = mysqli_query($koneksi, "SELECT DISTINCT order_id FROM riwayat_pembelian WHERE nama_kantin = '{$data['nama_kantin']}'");
                  while ($order = mysqli_fetch_assoc($ambil_data_order)) {
                      echo "<option value='{$order['order_id']}'>{$order['order_id']}</option>";
                  }
                ?>
              </select>                                
            </div>
            <div class="mb-4">
              <label class="block font-semibold mb-1">Report Description</label>
              <textarea name="deskripsi" required rows="4" class="textarea border textarea-bordered w-full"></textarea>
            </div>
            <div class="mb-4">
              <label class="block font-semibold mb-1">Upload Proof</label>
              <input type="file" name="bukti" accept="image/*" class="file-input file-input-bordered w-full" />
            </div>
          </div>
        </div>
      </div>

      <!-- Tombol submit di kanan bawah -->
      <div class="flex justify-end mt-6">
        <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-yellow-600 rounded-lg">Submit Report</button>
      </div>
    </form>
  </main>

  <script>
    AOS.init();

    const notyf = new Notyf({
      duration: 2000,
      position: { x: 'right', y: 'top' },
      types: [
        {
          type: 'success',
          background: '#FFB43B',
          icon: {
            className: 'notyf__icon--success',
            tagName: 'i',
          }
        },
        {
          type: 'error',
          background: '#d63031',
          icon: {
            className: 'notyf__icon--error',
            tagName: 'i',
          }
        }
      ]
    });

    // Show success message if redirected from proses_kelola_kantin.php
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'true') {
      notyf.success("Report sent successfully!");
    }

    // Form validation
    document.querySelector("form").addEventListener("submit", function (e) {
      const tanggal = document.querySelector("input[name='tanggal']").value.trim();
      const kategori = document.querySelector("select[name='kategori']").value.trim();
      const deskripsi = document.querySelector("textarea[name='deskripsi']").value.trim();

      if (!tanggal || !kategori || !deskripsi) {
        e.preventDefault();
        notyf.error("Please fill in all fields!");
      }
    });
  </script>
</body>
</html>
