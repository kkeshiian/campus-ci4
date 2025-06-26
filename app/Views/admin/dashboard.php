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
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />

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

  <title>Dashboard Admin</title>
</head>
<body class="min-h-screen flex flex-col mb-4">
  <main class="w-[90%] mx-auto mt-6">
    <h2 class="text-2xl font-bold mb-6">Dashboard Admin</h2>

    <?php $row_admin = $admin ?? []; ?>
    <?php $role_counts = $roleCounts ?? ['admin' => 0, 'penjual' => 0, 'pembeli' => 0]; ?>

    <!-- Profile Admin -->
    <div class="max-w-md mx-auto mb-10">
      <div class="w-full mb-10 px-4">
        <div class="bg-white border border-black rounded-xl p-6 shadow-lg text-center w-full">
          <p class="text-lg mb-2">
            Admin Name: <span class="font-medium"><?= esc($row_admin['nama'] ?? '-') ?></span>
          </p>
          <p class="text-lg mb-6">
            Role: <span class="font-medium"><?= esc($row_admin['jabatan'] ?? '-') ?></span>
          </p>
          <a href="<?= base_url('/admin/profile') ?>">
            <button class="btn bg-kuning hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded-lg shadow-md transition duration-300 ease-in-out w-full" type="button">
              Edit Profile
            </button>
          </a>
        </div>
      </div>
    </div>

    <!-- Statistik -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-2 mb-2">
      <div class="bg-white border border-black rounded-lg p-4 text-center shadow">
        <h3 class="text-lg font-semibold">Total Active Users</h3>
        <p class="text-2xl font-bold text-kuning"><?= $role_counts['pembeli'] ?? 0 ?></p>
      </div>
      <div class="bg-white border border-black rounded-lg p-4 text-center shadow">
        <h3 class="text-lg font-semibold">Total Active Sellers</h3>
        <p class="text-2xl font-bold text-kuning"><?= $role_counts['penjual'] ?? 0 ?></p>
      </div>
    </div>

    <!-- Navigasi Kelola -->
    <div class="grid grid-cols-2 md:grid-cols-2 gap-2 mb-2">
      <a href="<?= base_url('admin/kelola-pengguna') ?>" class="bg-white border border-black rounded-lg p-4 text-center hover:bg-gray-100 transition">
        <h4 class="text-lg font-semibold mb-2">Manage CampusEats's User</h4>
        <p class="text-gray-600 text-sm">Look and delete Campuseats's User data.</p>
      </a>
      <a href="<?= base_url('admin/kelola-kantin') ?>" class="bg-white border border-black rounded-lg p-4 text-center hover:bg-gray-100 transition">
        <h4 class="text-lg font-semibold mb-2">Manage Campuseats's Canteen</h4>
        <p class="text-gray-600 text-sm">Add, edit, and delete Campuseats's Canteen data.</p>
      </a>
    </div>
  </main>

  <script>
    const notyf = new Notyf({
      duration: 3000,
      position: { x: 'right', y: 'top' },
      types: [
        {
          type: 'success',
          background: '#FFB43B',
          icon: { className: 'notyf__icon--success', tagName: 'i' }
        },
        {
          type: 'error',
          background: '#d63031',
          icon: { className: 'notyf__icon--error', tagName: 'i' }
        }
      ]
    });

    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('success') === 'true') {
      notyf.success("Profile updated successfully!");
    }
    if (urlParams.get('error') === 'error') {
      notyf.error("Name and Position must be filled in!");
    }
    if (urlParams.get('success') === '1') {
      notyf.success('Successfully logged in as Admin!');
      window.history.replaceState({}, document.title, window.location.pathname);
    }
  </script>
</body>
</html>
