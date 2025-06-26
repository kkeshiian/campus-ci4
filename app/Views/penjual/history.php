

<?php
// history.php - halaman riwayat pesanan penjual

$activePage = 'history_seller';

// Contoh data riwayat pesanan (biasanya ambil dari database)
$riwayatPesanan = [
    [
        'id' => 1,
        'nama_pembeli' => 'Andi',
        'menu' => 'Nasi Goreng',
        'jumlah' => 2,
        'total_harga' => 30000,
        'status' => 'Selesai',
        'tanggal' => '2025-06-01 12:30:00',
    ],
    [
        'id' => 2,
        'nama_pembeli' => 'Budi',
        'menu' => 'Es Teh',
        'jumlah' => 1,
        'total_harga' => 5000,
        'status' => 'Dibatalkan',
        'tanggal' => '2025-06-02 09:45:00',
    ],
    [
        'id' => 3,
        'nama_pembeli' => 'Sari',
        'menu' => 'Mie Ayam',
        'jumlah' => 3,
        'total_harga' => 45000,
        'status' => 'Diproses',
        'tanggal' => '2025-06-03 14:10:00',
    ],
];

// Fungsi helper untuk warna status
function statusBadge($status) {
    switch (strtolower($status)) {
        case 'selesai':
            return '<span class="px-3 py-1 rounded-full bg-green-200 text-green-800 font-semibold">'.$status.'</span>';
        case 'diproses':
            return '<span class="px-3 py-1 rounded-full bg-yellow-200 text-yellow-800 font-semibold">'.$status.'</span>';
        case 'dibatalkan':
            return '<span class="px-3 py-1 rounded-full bg-red-200 text-red-800 font-semibold">'.$status.'</span>';
        default:
            return '<span class="px-3 py-1 rounded-full bg-gray-200 text-gray-800 font-semibold">'.$status.'</span>';
    }
}
?>
<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <title>Order History - Seller</title>
</head>
<body class="min-h-screen flex flex-col">

  <?php include '../../partials/navbar-penjual.php'; ?>

  <main class="w-[90%] mx-auto mt-6 flex-grow">
    <h2 class="text-2xl font-bold mb-4">Order History</h2>

    <div class="overflow-x-auto bg-white border rounded shadow">
      <table class="table w-full border-collapse">
        <thead class="bg-kuning text-white">
          <tr>
            <th class="p-3">No</th>
            <th class="p-3">Buyer Name</th>
            <th class="p-3">Menu</th>
            <th class="p-3">Quantity</th>
            <th class="p-3">Total Price</th>
            <th class="p-3">Status</th>
            <th class="p-3">Date</th>
            <th class="p-3">Change</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($riwayatPesanan)) : ?>
            <tr>
              <td colspan="7" class="p-4 text-center text-gray-500">No order history available.</td>
            </tr>
          <?php else: ?>
            <?php $no = 1; ?>
            <?php foreach ($riwayatPesanan as $pesanan): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="p-3"><?= $no++ ?></td>
                <td class="p-3"><?= htmlspecialchars($pesanan['nama_pembeli']) ?></td>
                <td class="p-3"><?= htmlspecialchars($pesanan['menu']) ?></td>
                <td class="p-3"><?= $pesanan['jumlah'] ?></td>
                <td class="p-3">Rp <?= number_format($pesanan['total_harga'], 0, ',', '.') ?></td>
                <td class="p-3"><?= statusBadge($pesanan['status']) ?></td>
                <td class="p-3"><?= date('d M Y H:i', strtotime($pesanan['tanggal'])) ?></td>
                <td class="p-3"><a><button>Update Status</button></a></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </main>

</body>
</html>