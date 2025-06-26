<?php $activePage = 'index'; ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">


<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

    <script>
        tailwind.config = {plugins: [daisyui]}
    </script>
  <script src="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.js"></script>

  <!-- Google Font -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />

  <title>Welcome to CampusEats</title>
</head>

<body class="min-h-screen flex flex-col">

  <!-- Navbar (belum login) -->
  <?= view('partial/navbar-belum-login') ?>

  <!-- Main content -->
  <div class="flex-1 flex items-center justify-center -mt-16">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-6 max-w-4xl mx-auto">
      <div>
        <img
          src="<?= base_url('assets/img/food.png') ?>"
          alt="Food Image"
          class="w-full h-auto p-8 lg:mr-8"
        />
      </div>
      <div class="flex flex-col justify-center">
        <p class="text-4xl font-bold mb-2">Smart Eating for Smart Students!</p>
        <p>Order fast, pay cashless, and skip the lines.</p>
        <a href="<?= base_url('pembeli/canteen') ?>" class="btn bg-kuning rounded-lg mt-4">
          Explore Foods!
        </a>
      </div>
    </div>
  </div>

</body>
</html>
