<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Edit Profil Admin</title>
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" rel="stylesheet" />
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
<body>
  <?= view('partial/navbar-admin') ?>
  <div class="p-6 max-w-xl mx-auto">
  <h1 class="text-2xl font-bold mb-6 text-gray-800">Edit Profil Admin</h1>

  <form action="<?= base_url('admin/profile') ?>" method="post" class="space-y-5">
    <!-- ID tersembunyi -->
    <input type="hidden" name="id_admin" value="<?= esc($admin['id_admin']) ?>" />

    <!-- Input Nama -->
    <div>
      <label for="nama" class="block text-sm font-semibold text-gray-700 mb-1">Nama Admin</label>
      <input
        type="text"
        id="nama"
        name="nama"
        value="<?= esc($admin['nama']) ?>"
        required
        class="input input-bordered w-full"
      />
    </div>

    <!-- Input Jabatan -->
    <div>
      <label for="jabatan" class="block text-sm font-semibold text-gray-700 mb-1">Jabatan</label>
      <input
        type="text"
        id="jabatan"
        name="jabatan"
        value="<?= esc($admin['jabatan']) ?>"
        required
        class="input input-bordered w-full"
      />
    </div>

    <!-- Tombol Submit -->
    <div>
      <button
        type="submit"
        class="w-full bg-yellow-500 hover:bg-yellow-600 text-black font-semibold py-2 px-4 rounded-md transition duration-200"
      >
        Simpan Perubahan
      </button>
    </div>
  </form>
</div>


  <script>
    const notyf = new Notyf({
      duration: 3000,
      position: { x: 'right', y: 'top' }
    });

    <?php if (session()->getFlashdata('success')): ?>
      notyf.success("Profil berhasil diperbarui!");
    <?php elseif (isset($_GET['error'])): ?>
      notyf.error("Nama dan jabatan tidak boleh kosong!");
    <?php endif; ?>
  </script>
</body>
</html>
