<?php
    if (isset($_GET['id_admin'])) {
        $id_admin = (int) $_GET['id_admin'];
    }
    $ambil_data = mysqli_query($koneksi, "
    SELECT nama_fakultas, id_fakultas FROM fakultas");
    $data = mysqli_fetch_assoc($ambil_data);

    $queryFakultas = mysqli_query($koneksi, "SELECT id_fakultas, nama_fakultas FROM fakultas ORDER BY nama_fakultas ASC");


    $id_fakultas_terpilih = '';

    $error = '';
    $success = '';


    if (isset($_POST['submit'])) {
        if ($_POST['password'] != $_POST['konfirmasi_password']) {
            $error = 'Password dan konfirmasi password tidak cocok.';
        } else {
            $username = $_POST['username'];
            $nama_penjual = $_POST['nama_penjual'];
            $nama_kantin = $_POST['nama_kantin'];
            $id_fakultas = $_POST['id_fakultas'];
            $link = $_POST['link'];
            $password = password_hash($_POST['konfirmasi_password'], PASSWORD_DEFAULT);

            $hasil = registrasiPenjual($koneksi, $username, $nama_penjual, 
            $nama_kantin, $id_fakultas, $password, $link);
            header("Location: kelola_kantin.php?id_admin=" . $id_admin);

            exit();
        }
    }
?>
 
 <!-- Modal -->
  <input type="checkbox" id="modal_register" class="modal-toggle" />
  <div class="modal">
    <div class="modal-box max-w-xl">
      <h3 class="font-bold text-lg text-center mb-4">Register Penjual</h3>

      <?php if (!empty($error)): ?>
        <div role="alert" class="alert alert-error mb-4">
          <?= htmlspecialchars($error) ?>
        </div>
      <?php endif; ?>

      <form method="POST" class="space-y-4">
        <input type="hidden" name="id_admin" value="<?= htmlspecialchars($id_admin) ?>">
        <div>
          <label class="label">Username Pemilik Kantin</label>
          <input type="text" name="username" class="input input-bordered w-full" required />
        </div>
        <div>
          <label class="label">Nama Penjual</label>
          <input type="text" name="nama_penjual" class="input input-bordered w-full" required />
        </div>
        <div>
          <label class="label">Nama Kantin</label>
          <input type="text" name="nama_kantin" class="input input-bordered w-full" required />
        </div>

        <div>
            <label class="label">Lokasi Kantin</label>
            <select  name="id_fakultas" class="select select-bordered w-full" required>
                <option value="">-- Pilih Fakultas --</option>
                <?php
                while ($fakultas = mysqli_fetch_assoc($queryFakultas)) {
                    $selected = ($fakultas['id_fakultas'] == $id_fakultas_terpilih) ? 'selected' : '';
                    echo "<option value='{$fakultas['id_fakultas']}' $selected>{$fakultas['nama_fakultas']}</option>";
                }
                ?>
            </select>
        </div>

        <div>
          <label class="label">Link Maps Kantin</label>
          <input type="text" name="link" class="input input-bordered w-full" required />
        </div>
        
        <div>
          <label class="label">Password</label>
          <input type="password" name="password" class="input input-bordered w-full" required />
        </div>
        <div>
          <label class="label">Konfirmasi Password</label>
          <input type="password" name="konfirmasi_password" class="input input-bordered w-full" required />
        </div>

        <div class="modal-action justify-between flex flex-col">
          <button type="submit" name="submit" class="btn btn-success text-white w-full">Register</button>
          <label for="modal_register" class="btn">Batal</label>
        </div>
      </form>
    </div>
  </div>

