<?= view('partial/navbar-admin') ?>

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
  <div class="p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Profil Admin</h1>

    <form action="<?= base_url('admin/profile') ?>" method="post" class="space-y-4">
      <input type="hidden" name="id_admin" value="<?= esc($admin['id_admin']) ?>" />

      <div>
        <label for="nama" class="block font-semibold mb-1">Nama Admin</label>
        <input
          type="text"
          id="nama"
          name="nama"
          value="<?= esc($admin['nama']) ?>"
          class="input input-bordered w-full"
          required
        />
      </div>

      <div>
        <label for="jabatan" class="block font-semibold mb-1">Jabatan</label>
        <input
          type="text"
          id="jabatan"
          name="jabatan"
          value="<?= esc($admin['jabatan']) ?>"
          class="input input-bordered w-full"
          required
        />
      </div>

      <div class="pt-2">
        <button type="submit" class="btn btn-primary w-full">Simpan Perubahan</button>
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
