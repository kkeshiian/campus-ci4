<?php
if (isset($_GET['id_pembeli'])) {
  $id_per_pembeli = $_GET['id_pembeli'];
} else {
    header("Location: /campuseats/pages/auth/logout.php");
    exit();
}

include "../../database/koneksi.php";
include "../../database/model.php";

require_once '../../middleware/role_auth.php';
require_role('pembeli');
?>

<!DOCTYPE html>
  <html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <title>Manage Your Profile</title>

    <!-- AOS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <!-- Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  </head>
  <body class="min-h-screen flex flex-col">

    <?php 
    $activePage = 'Profile';
    include '../../partials/navbar-pembeli.php'; ?>
    <?php $gambar_user_default = "/campuseats/assets/img/default-user.png"; ?>

    <main class="w-[90%] mx-auto mt-6 max-w-5xl mb-4" data-aos="fade-up" data-aos-duration="1000">
      <h2 class="text-2xl font-bold mb-4" data-aos="fade-right" data-aos-duration="1000">Manage Profile</h2>

      <form action="proses_kelola_profile.php" method="POST" enctype="multipart/form-data" class=" bg-white p-6 rounded-lg shadow border border-black">
        <?php
        $ambil_data = mysqli_query($koneksi, "
            SELECT * FROM pembeli WHERE id_pembeli='$id_per_pembeli'");
        $data = mysqli_fetch_assoc($ambil_data);
        $id_user_pembeli = $data['id_user'];

        $ambil_data_user = mysqli_query($koneksi, "SELECT username, nomor_wa, email FROM user WHERE id_user='$id_user_pembeli'");
        $data_user = mysqli_fetch_assoc($ambil_data_user);

        ?>

        <div class="flex flex-col md:flex-row gap-6">
          <input type="hidden" name="id_pembeli" value="<?= $id_per_pembeli ?>" />

          <?php
          $src_gambar = "/campuseats/" . ($data['gambar'] ?: "/assets/img/default-user.png");
          ?>
          <img src="<?= htmlspecialchars($src_gambar) ?>" alt="User Image" class="w-full md:w-64 h-64 object-cover rounded-lg border border-black" />

            <div class="flex flex-col md:flex-row gap-4 flex-1">
                <div class="flex-1">
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Your Fullname</label>
                        <input type="text" name="nama" value="<?= htmlspecialchars($data['nama']) ?>" class="input input-bordered w-full" />
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Your Username</label>
                        <input type="text" name="username" value="<?= htmlspecialchars($data_user['username']) ?>" class="input input-bordered w-full" />
                    </div>
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Your Campuseats ID</label>
                        <input type="text" disabled value="<?= htmlspecialchars($data['id_user']) ?>" class="input input-bordered w-full" />
                    </div>
                </div>
                <div class="flex-1">
                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Your Email</label>
                        <input type="text" name="email" accept="image/*" class="input input-bordered w-full" value="<?= htmlspecialchars($data_user['email']) ?>" />
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Your Whatsapp Number</label>
                        <input type="text" name="nomor_wa" accept="image/*" class="input input-bordered w-full" value="<?= htmlspecialchars($data_user['nomor_wa']) ?>"/>
                    </div>

                    <div class="mb-4">
                        <label class="block font-semibold mb-1">Your Photo</label>
                        <input type="file" name="foto_user" accept="image/*" class="file-input file-input-bordered w-full" />
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" name="submit" class="btn bg-kuning text-white hover:bg-yellow-600 rounded-lg">Save Changes</button>
                    </div>
                </div>
            </div>
        </div>
      </form>
    </main>

    <script>
      AOS.init();

      const notyf = new Notyf({
        duration: 2000,
        position: {
          x: 'right',
          y: 'top',
        },
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
    notyf.success("Changes saved successfully!");
    }

    const errorMessage = urlParams.get('error');
    if (errorMessage) {
    notyf.error(decodeURIComponent(errorMessage));
    }

      // Form validation
      document.querySelector("form").addEventListener("submit", function (e) {
        const nama = document.querySelector("input[name='nama']").value.trim();
        const usernama = document.querySelector("input[name='username']").value.trim();
        const email = document.querySelector("input[name='email']").value.trim();
        const nomor_wa = document.querySelector("input[name='nomor_wa']").value.trim();

        if (!nama || !usernama || !email || !nomor_wa) {
          e.preventDefault(); // stop form submit
          notyf.error("Please fill in all required fields!");
        }
      });
    </script>
  </body>
  </html>