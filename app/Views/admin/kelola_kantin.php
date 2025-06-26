<?= view('partial/navbar-admin') ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  

  <title>Kelola Kantin</title>
</head>
<body>
  <div class="flex">
    <main class="p-8 w-full">
      <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold">Kelola Data Kantin</h1>
            <a href="<?= base_url('admin/tambahKantin/' . $id_admin) ?>" class="btn bg-yellow-500 hover:bg-yellow-600 text-white">
  + Tambah Kantin
</a>

      </div>

      <?php if (empty($penjualList)) : ?>
        <p class="text-center text-lg p-6 text-gray-600">Tidak ada data kantin.</p>
      <?php else : ?>
        <div class="overflow-x-auto">
          <table class="table table-zebra w-full text-sm">
            <thead>
              <tr class="bg-yellow-500 text-black">
                <th>#</th>
                <th>Nama Penjual</th>
                <th>Username</th>
                <th>Nama Kantin</th>
                <th>Fakultas</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($penjualList as $i => $p): ?>
                <tr>
                  <td><?= $i + 1 ?></td>
                  <td><?= esc($p['nama']) ?></td>
                  <td><?= esc($p['username']) ?></td>
                  <td><?= esc($p['nama_kantin']) ?></td>
                  <td><?= esc($p['nama_fakultas']) ?></td>
                 <td class="space-x-2">
  <button onclick="confirmAuthorization(<?= $p['id_user'] ?>, <?= $id_admin ?>)"
    class="btn bg-yellow-500 hover:bg-yellow-600 text-white btn-sm p-4">
    Authorize
  </button>

  <button onclick="confirmDelete(<?= $p['id_user'] ?>, <?= $id_admin ?>)"
    class="btn bg-red-600 hover:bg-red-700 text-white btn-sm p-4">
    Hapus
  </button>
</td>

                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
        </div>
      <?php endif; ?>
    </main>
  </div>


  <script>
    function confirmDelete(id_user, id_admin) {
      Swal.fire({
        title: 'Are you sure?',
        text: "This canteen user will be deleted permanently!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#FFB43B',
        confirmButtonText: 'Yes, delete it'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url('admin/hapusKantin') ?>/" + id_user + "/" + id_admin;
        }
      });
    }

    function confirmAuthorization(id_penjual, id_admin) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You are about to authorize this canteen user!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#FFB43B',
        cancelButtonColor: '#e3342f',
        confirmButtonText: 'Yes, authorize'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = "<?= base_url('admin/editDataPenjual') ?>/" + id_penjual + "/" + id_admin;
        }
      });
    }
  </script>

  <script>
    const notyf = new Notyf({
      duration: 3000,
      position: { x: 'right', y: 'top' },
      types: [
        {
          type: 'success',
          background: '#28a745',
          icon: { className: 'notyf__icon--success', tagName: 'i' }
        }
      ]
    });

    const urlParams = new URLSearchParams(window.location.search);
    const successParam = urlParams.get('success');
    const errorParam = urlParams.get('error');

    if (urlParams.get('success') === 'true') {
      notyf.success('User data updated successfully!');
      history.replaceState(null, '', window.location.pathname);
    } else if (urlParams.get('success') === 'hapus') {
      notyf.error('Successfully deleted user!');
      history.replaceState(null, '', window.location.pathname);
    } else if (urlParams.get('success') === 'true') {
      notyf.success('User password updated successfully!');
      // Optional: remove success param after notification
      history.replaceState(null, '', window.location.pathname);
    }
  </script>

  <script>
  console.log("URL: " + window.location.href);
  console.log("success param: ", new URLSearchParams(window.location.search).get("success"));
</script>

</body>
 
</html>
