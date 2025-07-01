<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />

  <!-- Notyf -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>

  <title>Edit Menu - CampusEats!</title>
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
<body class="min-h-screen flex flex-col">
  <?= view('partial/navbar-penjual') ?>
<main class="w-[90%] mx-auto mt-6 max-w-xl mb-4">
  <h2 class="text-2xl font-bold mb-4 text-center">Edit Menu</h2>

  <form action="<?= base_url('penjual/edit-menu') ?>" method="POST" enctype="multipart/form-data"
        class="space-y-4 bg-white p-6 rounded-lg shadow border border-black">
    <input type="hidden" name="id_menu" value="<?= esc($menu['id_menu']) ?>" />
    <input type="hidden" name="id_penjual" value="<?= esc($id_penjual) ?>" />

    <div class="flex flex-col md:flex-row gap-6">
      <!-- Gambar -->
    <?php
      $gambar = !empty($menu['gambar']) ? '/campuseats/' . esc($menu['gambar']) : base_url('assets/img/default-menu.jpg');
    ?>
    <img src="<?= !empty($menu['gambar']) ? base_url($menu['gambar']) : base_url('assets/img/default-menu.jpg') ?>"
        alt="Gambar Menu" class="w-64 h-64 object-cover rounded border border-black" />



      <div class="flex-1">
        <!-- Nama Menu -->
        <div class="mb-4">
          <label class="block font-semibold mb-1">Menu Name</label>
          <input type="text" name="nama" class="input input-bordered w-full"
                 value="<?= esc($menu['nama_menu']) ?>" required />
        </div>

        <!-- Harga -->
        <div class="mb-4">
          <label class="block font-semibold mb-1">Price (Rp)</label>
          <input type="number" name="harga" class="input input-bordered w-full" min="0"
                 value="<?= esc($menu['harga']) ?>" required />
        </div>

        <!-- Upload Gambar Baru -->
        <div class="mb-4">
          <label class="block font-semibold mb-1">Change Picture</label>
          <input type="file" name="gambar" accept="image/*"
                 class="file-input file-input-bordered w-full" />
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end">
          <button type="submit" class="btn bg-yellow-500 text-white hover:bg-yellow-600">
            Save Changes
          </button>
        </div>
      </div>
    </div>
  </form>
</main>

<script>
  const notyf = new Notyf({
    duration: 3000,
    position: {x: 'right', y: 'top'},
    types: [
      {
        type: 'success',
        background: '#4BB543',
        icon: {className: 'notyf__icon--success', tagName: 'i'}
      },
      {
        type: 'error',
        background: '#d63031',
        icon: {className: 'notyf__icon--error', tagName: 'i'}
      }
    ]
  });

  // Tampilkan toast berdasarkan URL query
  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('success') === 'true') {
    notyf.success("Menu updated successfully!");
  } else if (urlParams.get('error') === 'true') {
    notyf.error("Failed to update menu.");
  }
</script>
</body>
</html>
