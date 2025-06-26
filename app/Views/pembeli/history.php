<?php $id_pembeli = $id_pembeli ?? null; ?>
<?php $activePage = $activePage ?? 'cart'; ?>

<?= view('partial/navbar-pembeli') ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />

</head>
<body class="min-h-screen flex flex-col">

  <h2 class="text-2xl font-bold mx-auto m-4" data-aos="fade-up" data-aos-duration="1000">Purchase History</h2>

  <div class="w-[90%] mx-auto mb-10" data-aos="fade-up" data-aos-duration="1000">
    <div class="overflow-x-auto bg-white border border-black rounded-lg shadow-md">
      <?php if (empty($riwayat)) : ?>
        <p class='text-base mx-auto m-4 text-center text-gray-500'>No order history yet.</p>
      <?php else : ?>
        <table class='table w-full'>
          <thead class='bg-yellow-500 text-white'>
            <tr>
              <th>No</th>
              <th>Order ID</th>
              <th>Canteen</th>
              <th>Menu</th>
              <th>Quantity</th>
              <th>Price</th>
              <th>Total</th>
              <th>Status</th>
              <th>Method</th>
              <th>Status</th>
              <th>Date & Time</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; foreach ($riwayat as $item) : ?>
              <tr>
                <td><?= $no++ ?></td>
                <td><?= esc($item['order_id']) ?></td>
                <td><?= esc($item['nama_kantin']) ?></td>
                <td><?= esc($item['menu']) ?></td>
                <td><?= esc($item['quantity']) ?></td>
                <td><?= esc($item['harga']) ?></td>
                <td><?= esc($item['total']) ?></td>
                <td><?= esc($item['status']) ?></td>
                <td><?= esc($item['tipe']) ?></td>
                <td><?= esc($item['status']) ?></td>
                <td><?= esc($item['tanggal']) ?></td>
              </tr>
            <?php endforeach ?>
          </tbody>
        </table>
      <?php endif ?>

    </div>
  </div>


</body>

<script>
  AOS.init({
  });
</script>

</html>
