<?php $id_pembeli = $id_pembeli ?? null; ?>
<?php $activePage = $activePage ?? 'about_us'; ?>

<?= view('partial/navbar-pembeli') ?>


<!DOCTYPE html>
<html data-theme="light" class="bg-background min-h-screen">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>About Us</title>

  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
</head>
<body class="flex flex-col min-h-screen">


<main class="flex-grow container mx-auto px-4">
  <h1 class="text-2xl font-bold mb-6 text-center text-black m-4" data-aos="fade-up" data-aos-duration="1000">Development Team</h1>
  
  <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl mx-auto">
    <!-- UI/UX Designer -->
    <div class="bg-white rounded-lg shadow p-6 text-center border border-1 border-black" data-aos="fade-right" data-aos-duration="1000">
      <img src="../../assets/img/pengembang/randy.jpg" alt="UI/UX Designer" class="mx-auto rounded-lg w-64 h-64 mb-4 object-cover" />
      <h2 class="text-xl font-semibold mb-1">Randy Febrian</h2>
      <p class="text-yellow-600 font-semibold mb-2">UI/UX Designer</p>
    </div>

    <!-- Front-End Developer -->
    <div class="bg-white rounded-lg shadow p-6 text-center border border-1 border-black" data-aos="fade-up" data-aos-duration="1000">
      <img src="../../assets/img/pengembang/rizky.jpg" alt="Front-End Developer" class="mx-auto rounded-lg w-64 h-64 mb-4 object-cover" />
      <h2 class="text-xl font-semibold mb-1">Muhammad Rizky</h2>
      <p class="text-yellow-600 font-semibold mb-2">Front-End Developer</p>
    </div>

    <!-- Back-End Developer -->
    <div class="bg-white rounded-lg shadow p-6 text-center border border-1 border-black" data-aos="fade-left" data-aos-duration="1000">
      <img src="../../assets/img/pengembang/ghani.JPG" alt="Back-End Developer" class="mx-auto rounded-lg w-64 h-64 mb-4 object-cover" />
      <h2 class="text-xl font-semibold mb-1">Ghani Mudzakir</h2>
      <p class="text-yellow-600 font-semibold mb-2">Back-End Developer</p>
    </div>
  </div>
</main>
<?= view('partial/footer') ?>
<script>
  AOS.init({
  });
</script>
</body>
</html>
