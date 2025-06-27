<?php $id_penjual = $id_penjual ?? null; ?>
<?php $activePage = $activePage ?? 'dashboard_seller'; ?>

<?= view('partial/navbar-penjual') ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>Seller Dashboard</title>

  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
</head>

<body class="min-h-screen flex flex-col">
<main class="w-[90%] mx-auto mt-6">
  <h2 class="text-2xl font-bold mb-4" data-aos="fade-right" data-aos-duration="1000">Seller Dashboard</h2>

  <div data-aos="fade-up" data-aos-duration="1000">
    Date: <h4 id="tanggalHariIni" class="text-2xl font-bold mb-4"></h4>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
      <div class="flex items-center gap-4 bg-white border border-black rounded-lg p-4 text-center">
        <div class="mx-auto">
          <h3 class="text-lg font-semibold text-black"><?= esc($nama_fakultas) ?></h3>
          <p class="text-2xl font-bold text-yellow-500"><?= esc($nama_kantin) ?></p>
        </div>
      </div>
      <div class="bg-white border border-black rounded-lg p-4 text-center flex items-center">
        <div class="mx-auto">
          <h3 class="text-lg font-semibold">Today's income</h3>
          <p class="text-2xl font-bold text-yellow-500">Rp <?= number_format($total_pendapatan ?? 0, 0, ',', '.') ?></p>
        </div>
      </div>
      <div class="bg-white border border-black rounded-lg p-4 text-center flex items-center">
        <div class="mx-auto">
          <h3 class="text-lg font-semibold">Today's orders</h3>
          <p class="text-2xl font-bold text-yellow-500"><?= esc($total_orderan) ?> Orders</p>
        </div>
      </div>
    </div>

    <!-- List Pesanan Masuk -->
    <div class="mb-8">
      <h3 class="text-xl font-semibold mb-4 text-center md:text-left">Incoming Orders</h3>
      <div class="space-y-6">
        <?php if (empty($riwayat)): ?>
          <p class="text-gray-500 text-base text-center">No orders yet</p>
        <?php else: ?>
          <?php foreach ($riwayat as $pesanan): ?>
            <div class="bg-white border border-black rounded-lg p-4 flex flex-col md:flex-row md:justify-between md:items-center gap-4 shadow-sm hover:shadow-md transition">
              <div class="flex-1 space-y-1 text-sm md:text-base">
                <p class="font-bold text-lg md:text-xl text-black"><?= esc($pesanan["menu"]) ?></p>
                <p class="text-gray-500">Order ID: <span class="text-black"><?= esc($pesanan["order_id"]) ?></span></p>
                <p class="text-gray-500">Date: <span class="text-black"><?= esc($pesanan["tanggal"]) ?></span></p>
                <p class="text-gray-500">Type Payment: <span class="text-black"><?= esc($pesanan["tipe"]) ?></span></p>
                <p class="text-gray-500">Payment Status: <span class="text-black"><?= esc($pesanan["status_pembayaran"]) ?></span></p>
                <p class="text-gray-500">Quantity: <span class="text-black"><?= esc($pesanan["quantity"]) ?></span></p>
                <p class="text-gray-500">Total: <span class="text-black">Rp <?= number_format($pesanan["total"]) ?></span></p>
                <p class="text-gray-500 font-medium">Note:
                  <span class="text-black"><?= empty($pesanan["notes"]) ? '-' : esc($pesanan["notes"]) ?></span>
                </p>
              </div>

              <form method="post" action="<?= base_url('/penjual/update-status') ?>" class="form-konfirmasi-status w-full md:w-64">
                <?= csrf_field() ?>
                <input type="hidden" name="order_id" value="<?= esc($pesanan["order_id"]) ?>">
                <input type="hidden" name="menu" value="<?= esc($pesanan["menu"]) ?>">
                <fieldset class="mb-2">
                  <?php $isDone = $pesanan["status"] === "Done"; ?>
                  <label for="status" class="block text-sm font-semibold mb-1">Order Status</label>
                  <select name="status" id="status" required class="select select-bordered w-full" <?= $isDone ? 'disabled' : '' ?>>
                    <option value="">Waiting to Confirm</option>
                    <?php
                      $statuses = ["Being Cooked", "Ready to Pickup", "Done"];
                      foreach ($statuses as $status) {
                          $selected = ($pesanan["status"] == $status) ? "selected" : "";
                          echo "<option value='$status' $selected>$status</option>";
                      }
                    ?>
                  </select>
                </fieldset>
                <button type="submit" name="submit" class="btn btn-sm w-full bg-kuning text-white rounded-lg mt-1 hover:bg-yellow-600" <?= $isDone ? 'disabled' : '' ?>>
                  Update
                </button>
                <?php if ($isDone): ?>
                  <p class="text-sm text-gray-500 mt-1 italic">Order has been marked as Done.</p>
                <?php endif; ?>
              </form>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<script>
  document.getElementById("tanggalHariIni").textContent = new Date().toLocaleDateString("id-ID", {
    weekday: "long", day: "numeric", month: "long", year: "numeric"
  });
  AOS.init();
</script>

<script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
<script>
  const notyf = new Notyf({
    duration: 3000,
    position: { x: 'right', y: 'top' },
    types: [
      { type: 'success', background: '#FFB43B', icon: { className: 'notyf__icon--success', tagName: 'i' }},
      { type: 'error', background: '#d63031', icon: { className: 'notyf__icon--error', tagName: 'i' }}
    ]
  });

  const urlParams = new URLSearchParams(window.location.search);
  if (urlParams.get('success') === '1') {
    notyf.success('Successfully logged in as Seller!');
    window.history.replaceState({}, document.title, window.location.pathname);
  }
</script>
</body>
</html>
