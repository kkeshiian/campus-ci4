<?php $activePage = $activePage ?? 'manage_canteen_seller'; ?>
<?= view('partial/navbar-penjual') ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>Manage Canteen</title>

  <!-- AOS -->
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Notyf -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
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

<?php
  $gambar_kantin_default = "../../assets/img/default-canteen.jpg";
  $gambar_kantin = $penjual['gambar'] ?? '';
  $src_gambar = $gambar_kantin ? base_url($gambar_kantin) : base_url($gambar_kantin_default);
?>

<main class="w-[90%] mx-auto mt-6 max-w-5xl mb-4" data-aos="fade-up" data-aos-duration="1000">
  <h2 class="text-2xl font-bold mb-4" data-aos="fade-right" data-aos-duration="1000">Manage Canteen</h2>

  <form action="<?= base_url('penjual/proses-kelola-kantin') ?>" method="POST" enctype="multipart/form-data"
        class="bg-white p-6 rounded-lg shadow border border-black">

    <input type="hidden" name="id_penjual" value="<?= esc($id_penjual) ?>" />

    <div class="flex flex-col md:flex-row gap-6">
      <img src="<?= esc($src_gambar) ?>" alt="Canteen Image"
           class="w-full md:w-64 h-64 object-cover rounded-lg border border-black" />

      <div class="flex flex-col md:flex-row gap-4 flex-1">
        <div class="flex-1">
          <div class="mb-4">
            <label class="block font-semibold mb-1">Canteen Name</label>
            <input type="text" name="nama_kantin"
                   value="<?= esc($penjual['nama_kantin'] ?? '') ?>"
                   class="input input-bordered w-full" />
          </div>

          <div>
            <label class="block font-semibold mb-1">Location (Faculty)</label>
            <select name="id_fakultas" class="select select-bordered w-full">
              <option value="">-- Select Faculty --</option>
              <?php foreach ($fakultas as $f): ?>
                <option value="<?= esc($f['id_fakultas']) ?>"
                  <?= $f['id_fakultas'] == ($penjual['id_fakultas'] ?? '') ? 'selected' : '' ?>>
                  <?= esc($f['nama_fakultas']) ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>
        </div>

        <div class="flex-1">
          <div class="mb-4">
            <label class="block font-semibold mb-1">Canteen Location Link</label>
            <input type="text" name="link" value="<?= esc($penjual['link'] ?? '') ?>"
                   class="input input-bordered w-full" />
          </div>

          <div class="mb-4">
            <label class="block font-semibold mb-1">Canteen Photo</label>
            <input type="file" name="foto_kantin" accept="image/*"
                   class="file-input file-input-bordered w-full" />
          </div>

          <div class="flex justify-end">
            <button type="submit" name="submit"
                    class="btn bg-yellow-500 p-4 text-white hover:bg-yellow-600 rounded-lg">
              Save Changes
            </button>
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
    position: { x: 'right', y: 'top' },
    types: [
      { type: 'success', background: '#FFB43B' },
      { type: 'error', background: '#d63031' }
    ]
  });

  <?php if (session()->getFlashdata('success')): ?>
    notyf.success("<?= esc(session()->getFlashdata('success')) ?>");
  <?php elseif (session()->getFlashdata('error')): ?>
    notyf.error("<?= esc(session()->getFlashdata('error')) ?>");
  <?php endif; ?>

  document.querySelector("form").addEventListener("submit", function (e) {
    const namaKantin = document.querySelector("input[name='nama_kantin']").value.trim();
    const idFakultas = document.querySelector("select[name='id_fakultas']").value.trim();
    const link = document.querySelector("input[name='link']").value.trim();

    if (!namaKantin || !idFakultas || !link) {
      e.preventDefault();
      notyf.error("Please fill in all required fields!");
    }
  });
</script>
</body>
</html>
