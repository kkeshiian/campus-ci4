<?php $id_pembeli = $id_pembeli ?? null; ?>
<?php $activePage = $activePage ?? 'cart'; ?>

<?= view('partial/navbar-pembeli') ?>

<!DOCTYPE html>
<html lang="id" data-theme="light">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pembayaran Sukses</title>
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
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


  <!-- Konten utama setelah navbar -->
  <div class="flex justify-center items-center pt-24 px-4">
    <div class="bg-white shadow-md rounded-xl p-8 max-w-md w-full text-center border border-black">
      
      <svg class="mx-auto mb-4 text-green-500 w-16 h-16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
      </svg>

      <h1 class="text-2xl font-bold text-gray-800 mb-2">Payment Successful!</h1>
      <p class="text-gray-600 mb-4">
       Thank you for your purchase.<br>
       Your order <strong>#<?= htmlspecialchars($order_id) ?></strong> has been placed.

      </p>

      <a href="/pembeli/history?id_pembeli=<?= $id_pembeli ?>" class="inline-block mt-4 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-300">
        Track Your Order
      </a>

    </div>
  </div>

</body>
</html>