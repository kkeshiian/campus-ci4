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
  <title>Kelola Menu</title>
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

<main class="w-full max-w-7xl mx-auto mt-6 px-4 sm:px-6 lg:px-8" data-aos="fade-up" data-aos-duration="1000">
  <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
    <h2 class="text-2xl font-bold mb-4 sm:mb-0" data-aos="fade-right" data-aos-duration="1000">Manage Menu</h2>
    <!-- Tombol Tambah Menu -->
    <div>
      <a href="<?= base_url('penjual/tambah-menu') ?>" 
         class="btn bg-kuning text-white font-semibold rounded-lg px-4 py-2 hover:bg-yellow-600 whitespace-nowrap">
        + Add Menu
      </a>
    </div>
  </div>

  <!-- Tabel Daftar Menu -->
  <div class="overflow-x-auto bg-white rounded-lg shadow border border-black">
    <?php if (empty($daftar_menu)): ?>
      <p class='text-base mx-auto m-4 text-center text-gray-500'>No menu has been added yet</p>
    <?php else: ?>
      <table class='table w-full min-w-[600px] text-center'>
        <thead class='bg-yellow-500 text-white'>
          <tr>
            <th class='px-2 py-3'>No</th>
            <th class='px-2 py-3'>Menu Name</th>
            <th class='px-2 py-3'>Price</th>
            <th class='px-2 py-3'>Action</th>
          </tr>
        </thead>
        <tbody>
        <?php $no = 1; foreach ($daftar_menu as $menu): ?>
          <tr class='hover:bg-gray-100'>
            <td class='px-2 py-2'><?= $no++ ?></td>
            <td class='px-2 py-2'><?= esc($menu['nama_menu']) ?></td>
            <td class='px-2 py-2'>Rp <?= number_format($menu['harga'], 0, ',', '.') ?></td>
            <td class='px-2 py-2 space-x-2 whitespace-nowrap'>
              <a href="<?= base_url('penjual/edit-menu?id_menu=' . $menu['id_menu']) ?>" 
                 class='btn btn-sm bg-yellow-500 rounded-lg text-white hover:bg-yellow-600'>
                Edit Menu
              </a>
            <a href="<?= base_url('penjual/proses-hapus-menu/' . $menu['id_menu']) ?>" 
              onclick="return confirm('Are you sure you want to delete this menu?')"
              class="btn btn-sm bg-red-500 text-white hover:bg-red-600 rounded-lg">
              Delete
            </a>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>
  </div>
</main>

<script>
  AOS.init();
</script>

<script>
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

  const urlParams = new URLSearchParams(window.location.search);
  const successParam = urlParams.get('success');
  const errorParam = urlParams.get('error');

  if (successParam === 'true') {
    notyf.success("Menu changed successfully!");
  } else if (successParam === 'hapus') {
    notyf.success("Menu deleted successfully!");
  } else if (successParam === 'tambah') {
    notyf.success("Menu added successfully!");
  }

  if (errorParam === 'true') {
    notyf.error("Failed to change menu!");
  } else if (errorParam === 'hapus') {
    notyf.error("Failed to delete menu!");
  }
</script>

</body>
</html>
