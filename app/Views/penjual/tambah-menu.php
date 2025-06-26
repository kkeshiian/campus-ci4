<?php $id_penjual = $id_penjual ?? null; ?>
<?php $activePage = $activePage ?? 'manage_menu_seller'; ?>

<?= view('partial/navbar-penjual') ?>
<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <!-- Notyf -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <title>Add Menu</title>
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

<main class="w-[90%] mx-auto mt-6 max-w-xl">
  <h2 class="text-2xl font-bold mb-4 text-center">Add New Menu</h2>

  <form action="<?= base_url('penjual/proses-tambah-menu') ?>" method="POST" enctype="multipart/form-data" class="space-y-4 bg-white p-6 rounded-lg shadow border" id="menuForm">
    <input type="hidden" name="id_penjual" value="<?= esc($id_penjual) ?>" />

    <!-- Nama Menu -->
    <div>
      <label class="block font-semibold mb-1">Menu Name</label>
      <input type="text" name="nama" class="input input-bordered w-full" />
    </div>

    <!-- Harga -->
    <div>
      <label class="block font-semibold mb-1">Price (Rp)</label>
      <input type="number" name="harga" class="input input-bordered w-full" min="0" />
    </div>

    <!-- Upload Gambar -->
    <div>
      <label class="block font-semibold mb-1">Menu Picture</label>
      <input type="file" name="gambar" accept="image/*" class="file-input file-input-bordered w-full" />
    </div>

    <!-- Tombol Simpan -->
    <div class="flex justify-end">
      <button type="submit" class="btn bg-kuning text-white hover:bg-yellow-600">Add Menu</button>
    </div>
  </form>
</main>

<script>
const notyf = new Notyf({
  duration: 2000,
  position: { x: 'right', y: 'top' },
  types: [
    { type: 'success', background: '#FFB43B' },
    { type: 'error', background: '#d63031' }
  ]
});

// Show flashdata success or error
<?php if (session()->getFlashdata('success')): ?>
  notyf.success("<?= session()->getFlashdata('success') ?>");
<?php elseif (session()->getFlashdata('error')): ?>
  notyf.error("<?= session()->getFlashdata('error') ?>");
<?php endif; ?>

// Client-side validation
document.getElementById("menuForm").addEventListener("submit", function (e) {
  const nama = this.querySelector("input[name='nama']").value.trim();
  const harga = this.querySelector("input[name='harga']").value.trim();
  const gambar = this.querySelector("input[name='gambar']").files;

  if (!nama || !harga || harga < 0 || gambar.length === 0) {
    e.preventDefault();
    notyf.error("Please fill in all required fields!");
  }
});
</script>

