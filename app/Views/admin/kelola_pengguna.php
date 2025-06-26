<?php $activePage = 'kelola_pengguna'; ?>
<?= view('partial/navbar-admin') ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
  <title>Dashboard Admin - Manage User</title>
</head>
<body class="min-h-screen flex flex-col mb-4">
<main class="w-[90%] max-w-5xl mx-auto mt-6">
  <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
    <h2 class="text-2xl sm:text-3xl font-bold text-black">Manage User</h2>
  </div>

  <div class="overflow-x-auto bg-white border rounded-lg shadow">
    <?php if (empty($pembeliList)) : ?>
      <p class="text-center text-lg p-6 text-gray-600">No user data found.</p>
    <?php else : ?>
      <table class="table w-full text-sm sm:text-base text-center">
        <thead class="bg-yellow-500 text-white">
          <tr>
            <th class="p-2 sm:p-3">No</th>
            <th class="p-2 sm:p-3">Full Name</th>
            <th class="p-2 sm:p-3">Username</th>
            <th class="p-2 sm:p-3">Action</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($pembeliList as $no => $row_user): ?>
          <tr class="hover:bg-gray-50">
            <td class="p-2 sm:p-3"><?= $no + 1 ?></td>
            <td class="p-2 sm:p-3"><?= esc($row_user['nama']) ?></td>
            <td class="p-2 sm:p-3"><?= esc($row_user['username']) ?></td>
            <td class="p-2 sm:p-3 flex flex-col sm:flex-row justify-center items-center gap-2">
              <a class="btn btn-sm bg-kuning text-white hover:bg-yellow-600 transition rounded-lg"
                 onclick="confirmAuthorization(<?= $row_user['id_user'] ?>)">
                 Authorization
              </a>
            <a class="btn btn-sm bg-red-500 text-white hover:bg-red-600 transition rounded-lg"
              onclick="confirmDelete('<?= base_url('admin/hapusPembeli/' . $row_user['id_user'] . '/' . $id_admin) ?>')">
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
  function confirmAuthorization(id_pembeli) {
    Swal.fire({
      title: 'Are you sure?',
      text: "You are about to authorize this user!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#FFB43B',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, authorize'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = `<?= base_url('admin/editDataPembeli') ?>/${id_pembeli}`;
      }
    });
  }

  function confirmDelete(deleteUrl) {
    Swal.fire({
      title: 'Are you sure?',
      text: "This action cannot be undone. The user will be deleted permanently.",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#e3342f',
      cancelButtonColor: '#FFB43B',
      confirmButtonText: 'Yes, delete'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = deleteUrl;
      }
    });
  }

</script>

<script>
  const notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'top' },
    types: [
      { type: 'success', background: '#28a745', icon: { className: 'notyf__icon--success', tagName: 'i' }},
      { type: 'error', background: '#d63031', icon: { className: 'notyf__icon--error', tagName: 'i' }}
    ]
  });

  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('success') === 'true') {
    notyf.success('User data updated successfully!');
    history.replaceState(null, '', window.location.pathname);
  } else if (urlParams.get('success') === 'hapus') {
    notyf.success('Successfully deleted user!');
    history.replaceState(null, '', window.location.pathname);
  }
</script>
</body>
</html>
