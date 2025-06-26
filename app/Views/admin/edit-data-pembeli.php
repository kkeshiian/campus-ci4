<?php $id_admin = $id_admin ?? null; ?>
<?php $activePage = $activePage ?? 'dashboard'; ?>
<?= view('partial/navbar-admin') ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Edit Data Pembeli</title>
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
      <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
</head>
<body class="font-inter text-gray-900">

  <div class="min-h-screen flex items-center justify-center bg-gray-100 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-lg">
      <h2 class="text-center text-2xl font-bold text-gray-900 mb-6">Edit Data Pembeli</h2>

      <?php if (session()->getFlashdata('error')): ?>
        <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
          <?= session()->getFlashdata('error') ?>
        </div>
      <?php endif; ?>
      <?php if (session()->getFlashdata('success')): ?>
        <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
          <?= session()->getFlashdata('success') ?>
        </div>
      <?php endif; ?>

      <form action="<?= base_url('admin/editDataPembeli/' . $pembeli['id_user']) ?>" method="post" class="space-y-6">
        <?= csrf_field() ?>

        <div>
          <label class="block text-sm font-medium text-gray-700">Nama Admin</label>
          <input type="text" name="nama" value="<?= esc($admin['nama'] ?? '') ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Password Admin</label>
          <input type="password" name="password" placeholder="Masukkan password admin" class="mt-1 p-2 w-full border border-gray-300 rounded" required />
        </div>

        <hr class="my-4">

        <div>
          <label class="block text-sm font-medium text-gray-700">Username Pembeli</label>
          <input type="text" name="username" value="<?= esc($pembeli['username']) ?>" class="mt-1 p-2 w-full border border-gray-300 rounded" required />
        </div>

        <div>
          <label class="block text-sm font-medium text-gray-700">Password Baru</label>
          <input type="password" name="new_password" placeholder="Password baru pembeli" class="mt-1 p-2 w-full border border-gray-300 rounded" required />
        </div>

        <div>
          <button type="submit" class="w-full py-2 px-4 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded-lg shadow-md transition duration-300">
            Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
