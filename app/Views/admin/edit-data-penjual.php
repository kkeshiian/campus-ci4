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
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <title>Edit Data Penjual</title>
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
<body class="min-h-screen flex flex-col bg-background">

<main class="w-[90%] mx-auto mt-6">
  <h2 class="text-2xl font-bold mb-6 ml-6">Change Canteen Seller's Password</h2>

  <form method="POST" class="bg-white p-6 rounded-lg shadow border w-full mx-auto px-6" style="max-width: 1200px;">
    <div class="flex flex-wrap gap-6">
      <!-- Bagian Admin -->
      <div class="flex-1 min-w-[300px] space-y-6">
        <h2 class="text-xl font-semibold border-b pb-2 mb-4">Authentication Admin</h2>

        <div>
          <label class="block font-semibold mb-1">Admin Name</label>
          <input type="text" name="nama" value="<?= esc($admin['admin_username']) ?>" class="input input-bordered w-full" readonly />
        </div>

        <div>
          <label class="block font-semibold mb-1">Admin Password</label>
          <input type="password" name="password" class="input input-bordered w-full" placeholder="Enter your admin password" required />
        </div>
      </div>

      <!-- Bagian User Penjual -->
      <div class="flex-1 min-w-[300px] space-y-6">
        <h2 class="text-xl font-semibold border-b pb-2 mb-4">Seller's Credentials</h2>

        <div>
          <label class="block font-semibold mb-1">New Username</label>
          <input type="text" name="username" class="input input-bordered w-full" placeholder="Enter new username" required />
        </div>

        <div>
          <label class="block font-semibold mb-1">New Password</label>
          <input type="password" name="new_password" class="input input-bordered w-full" placeholder="Enter new password" required />
          <p class="text-gray-500 mt-1 text-xs leading-snug">
            Password must be at least 8 characters and include uppercase, lowercase, number, and symbol.
          </p>
        </div>

        <div class="flex justify-between mt-6">
          <a href="<?= base_url('admin/kelola-kantin') ?>" class="btn btn-outline border-yellow-500 text-yellow-500">← Back to Kantin</a>
          <button type="submit" class="btn bg-yellow-500 text-white hover:bg-yellow-600">Save Changes</button>
        </div>
      </div>
    </div>
  </form>
</main>

<!-- Notyf error notification -->
<script>
  const notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'top' },
    types: [
      {
        type: 'error',
        background: '#dc3545',
        icon: {
          className: 'notyf__icon--error',
          tagName: 'i',
        },
      },
      {
        type: 'success',
        background: '#28a745',
        icon: {
          className: 'notyf__icon--success',
          tagName: 'i',
        },
      }
    ],
  });

  <?php if (!empty($error_message)) : ?>
    notyf.error("<?= esc($error_message) ?>");
  <?php endif; ?>
</script>

</body>
</html>
