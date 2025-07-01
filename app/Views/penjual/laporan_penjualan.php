<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="<?= base_url('campuseats/dist/output.css') ?>" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
</head>
<body class="min-h-screen flex flex-col">
  <?= view('partial/navbar-penjual') ?>

<main class="w-[90%] mx-auto mt-6 flex-grow max-w-6xl">
  <h2 class="text-2xl font-bold mb-4" data-aos="fade-right" data-aos-duration="1000">Weekly Sales Report</h2>

  <div data-aos="fade-up" data-aos-duration="1000">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 mb-6">
      <div class="bg-white shadow rounded-lg p-4 border border-black">
        <h3 class="text-sm text-black font-medium">Total Orders This Week</h3>
        <p class="text-xl font-bold text-kuning"><?= esc($ringkasan['qty']) ?></p>
      </div>
      <div class="bg-white shadow rounded-lg p-4 border border-black">
        <h3 class="text-sm text-black font-medium">Total Income</h3>
        <p class="text-xl font-bold text-kuning">Rp <?= number_format($ringkasan['total'] ?? 0, 0, ',', '.') ?></p>
      </div>
      <div class="bg-white shadow rounded-lg p-4 border border-black">
        <h3 class="text-sm text-black font-medium">Best Selling Day</h3>
        <p class="text-xl font-bold text-kuning"><?= esc($best_day['hari'] ?? '—') ?></p>

      </div>
      <div class="bg-white shadow rounded-lg p-4 border border-black">
        <h3 class="text-sm text-black font-medium">7 Days Latest</h3>
        <p class="text-xl font-bold text-kuning"><?= esc($tanggal_awal . ' - ' . $tanggal_akhir) ?></p>
      </div>
    </div>

    <div class="bg-white p-4 rounded-lg shadow border border-black mb-6">
      <h3 class="text-lg font-semibold mb-4">Sales in the Last 7 Days</h3>
      <canvas id="weeklyChart" height="80"></canvas>
    </div>
  </div>
</main>

<script>
  const chartLabels = <?= json_encode($labels) ?>;
  const chartData = <?= json_encode($sales) ?>;

  AOS.init();

  window.addEventListener('DOMContentLoaded', () => {
    const isMobile = window.innerWidth < 768;
    const ctx = document.getElementById('weeklyChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: chartLabels,
        datasets: [{
          label: isMobile ? '' : 'Sales (Rp)',
          data: chartData,
          borderColor: '#facc15',
          backgroundColor: '#fde68a',
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            display: !isMobile,
            beginAtZero: true,
            ticks: {
              callback: function(value) {
                return 'Rp ' + value.toLocaleString();
              }
            }
          }
        },
        plugins: {
          legend: { display: !isMobile }
        }
      }
    });
  });
</script>

</body>
</html>
