<?php $id_admin = $id_admin ?? null; ?>
<?php $activePage = $activePage ?? 'dashboard'; ?>
<?= view('partial/navbar-admin') ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <!-- Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <title>Add Canteen CampusEats!</title>
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
        <main class="w-[90%] mx-auto mt-6 max-w-xl">
        <h2 class="text-2xl font-bold mb-4 text-center">Add New Canteen</h2>

        <?php if (session()->getFlashdata('error')) : ?>
            <div class="alert alert-error mb-4">
            <?= esc(session()->getFlashdata('error')) ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="<?= base_url('admin/simpanKantin') ?>" class="space-y-6 bg-white p-6 rounded-lg shadow border border-black mb-8">
            <input type="hidden" name="id_admin" value="<?= esc($id_admin) ?>">

            <div class="flex flex-col md:flex-row gap-6">
            <div class="flex-1 space-y-4">
                <div>
                <label class="block font-semibold mb-1">Seller Username</label>
                <input type="text" name="username" class="input input-bordered w-full" required />
                </div>

                <div>
                <label class="block font-semibold mb-1">Seller Name</label>
                <input type="text" name="nama_penjual" class="input input-bordered w-full" required />
                </div>

                <div>
                <label class="block font-semibold mb-1">Canteen Name</label>
                <input type="text" name="nama_kantin" class="input input-bordered w-full" required />
                </div>

                <div>
                <label class="block font-semibold mb-1">Canteen Location</label>
                <select name="id_fakultas" class="select select-bordered w-full" required>
                    <option value="">-- Select Faculty --</option>
                    <?php foreach ($fakultasList as $f) : ?>
                    <option value="<?= esc($f['id_fakultas']) ?>"><?= esc($f['nama_fakultas']) ?></option>
                    <?php endforeach ?>
                </select>
                </div>
            </div>

            <div class="flex-1 flex flex-col justify-between space-y-4">
                <div>
                <label class="block font-semibold mb-1">Canteen Maps Link</label>
                <input type="text" name="link" class="input input-bordered w-full" required />
                </div>

                <div>
                <label class="block font-semibold mb-1">Password</label>
                <input type="password" name="password" class="input input-bordered w-full" required />
                </div>

                <div>
                <label class="block font-semibold mb-1">Confirm Password</label>
                <input type="password" name="konfirmasi_password" class="input input-bordered w-full" required />
                </div>

                <div class="flex justify-end pt-2">
                <button type="submit" class="btn bg-kuning text-white hover:bg-yellow-600 rounded-lg">
                    Add Canteen
                </button>
                </div>
            </div>
            </div>
        </form>
</main>

  </body>
</html>

<!-- Notyf JS -->
<script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
<script>
const notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'top' },
    dismissible: true
});

<?php if (isset($error) && !empty($error)): ?>
    notyf.error(<?= json_encode(htmlspecialchars($error, ENT_QUOTES, 'UTF-8')) ?>);
<?php endif; ?>
</script>


<script>
AOS.init();
</script>
