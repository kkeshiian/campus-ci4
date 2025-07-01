<?php
$kantin = $penjual['nama_kantin'] ?? 'Kantin';
$gambarKantin = $penjual['gambar'] ?? 'assets/img/default-canteen.jpg';
$linkKantin = $penjual['link'] ?? '';
?>


<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Notyf -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
    <link href="/campuseats/dist/output.css" rel="stylesheet" />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap"
      rel="stylesheet"
    />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />

    <title>Menu Kantin</title>
</head>
<body class="min-h-screen flex flex-col">

<?= view('partial/navbar-pembeli') ?>

<div class="flex w-full max-w-sm sm:max-w-md mx-4 sm:mx-6 md:mx-auto m-4 sm:m-6 p-3 sm:p-4 border border-black rounded-xl shadow-sm bg-white"
data-aos="fade-down" data-aos-duration="1000">
   <div class="mx-auto flex flex-col sm:flex-row items-center gap-4 sm:gap-6 w-full">
        <!-- Bagian kiri: gambar -->
        <?php
            $gambarKantin = !empty($penjual['gambar']) ? $penjual['gambar'] : '../../assets/img/default-canteen.jpg';
        ?>
       <!-- Container fleksibel horizontal -->
<div class="flex flex-row items-center gap-3 sm:gap-4 md:gap-6 w-full">
    
    <!-- Container fleksibel horizontal -->
    <div class="flex flex-row items-center gap-4 w-full">
        
        <!-- Bagian gambar - ukuran tetap -->
        <div class="w-40 flex-shrink-0">
            <img 
                src="../../assets/<?= htmlspecialchars($gambarKantin) ?>" 
                alt="Gambar Kantin <?= htmlspecialchars($kantin) ?>" 
                class="w-full h-32 object-cover rounded-lg shadow-sm" 
            />
        </div>

        <!-- Bagian kanan -->
        <div class="flex-1 flex flex-col justify-center space-y-2 overflow-hidden">
            
            <!-- Nama kantin -->
            <h2 class="text-black text-lg font-bold leading-tight break-words">
                <?= htmlspecialchars($kantin) ?>
            </h2>

            <!-- Tombol arah -->
            <a 
                href="<?= htmlspecialchars($linkKantin) ?>" 
                target="_blank"
                class="inline-block bg-yellow-500 hover:bg-yellow-600 text-black text-sm font-medium px-4 py-2 rounded-md transition duration-200 w-fit max-w-full"
            >
                Direction to Canteen
            </a>
        </div>
    </div>
</div>

   </div>
</div>

<!-- Tempat menampilkan menu -->
<div id="card-container" class="flex-grow grid grid-cols-2 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2 sm:gap-4 w-[95%] sm:w-[90%] mx-auto mb-8" data-aos="fade-up" data-aos-duration="1000">
    <?php if (!empty($menus)): ?>
        <?php foreach ($menus as $row_menu): ?>
            <?php
                $nama   = htmlspecialchars($row_menu['nama_menu']);
                $harga  = (int) $row_menu['harga'];
                $gambar = htmlspecialchars($row_menu['gambar'] ?? '../../assets/img/default-menu.jpg');
            ?>
            <div class="flex flex-col justify-between bg-white rounded-lg shadow-lg border border-black">
                <div class="p-2 sm:p-4">
                    <img src="/campuseats/public/../../<?= htmlspecialchars($gambar) ?>" alt="<?= $nama ?>" class="rounded-t-lg w-full h-32 sm:h-40 md:h-48 object-cover mb-1" />
                    <div>
                        <h2 class="text-sm sm:text-lg md:text-xl font-semibold leading-tight mb-1"><?= $nama ?></h2>
                        <p class="text-xs sm:text-sm md:text-base text-gray-600">Rp <?= number_format($harga, 0, ',', '.') ?></p>
                    </div>
                </div>
                <div class="p-2 sm:p-4">
                    <button
                        class="btn bg-yellow-500 text-xs sm:text-sm text-black rounded-lg px-2 sm:px-4 py-1 sm:py-2 hover:bg-yellow-600 w-full text-center add-to-cart"
                        data-nama="<?= $nama ?>"
                        data-harga="<?= $harga ?>"
                        data-gambar="<?= $gambar ?>"
                        data-kantin="<?= htmlspecialchars($kantin) ?>"
                    >Add to Cart</button>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p class="text-center col-span-full text-gray-500">Tidak ada menu tersedia untuk kantin ini.</p>
    <?php endif; ?>
</div>


<script>
  const idPembeli = <?= json_encode($id_pembeli) ?>;
  const cartKey = `cart_user_${idPembeli}`;
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    setupCartButtons();
    updateCartUI();
});



const notyf = new Notyf({
  duration: 2000,
  position: {
    x: 'right',
    y: 'top',
  },
  types: [
    {
      type: 'success',
      background: '#FFB43B',
      icon: {
        className: 'notyf__icon--success',
        tagName: 'i',
      }
    },
    {
      type: 'error',
      background: '#d63031',
      icon: {
        className: 'notyf__icon--error',
        tagName: 'i',
      }
    }
  ]
});


function setupCartButtons() {
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', () => {
            const nama = button.dataset.nama;
            const harga = parseInt(button.dataset.harga);
            const gambar = button.dataset.gambar;
            const kantin = button.dataset.kantin;

            let cart = JSON.parse(localStorage.getItem(cartKey)) || [];

            if (cart.length > 0) {
                const existingKantin = cart[0].kantin;
                if (kantin !== existingKantin) {
                    notyf.error("Cannot add items from a different canteen.");
                    return;
                }
            }

            const existingIndex = cart.findIndex(item => item.nama === nama);
            if (existingIndex !== -1) {
                cart[existingIndex].quantity += 1;
            } else {
                cart.push({
                    nama: nama,
                    harga: harga,
                    gambar: gambar,
                    kantin: kantin,
                    quantity: 1,
                    notes: ''
                });
            }

            localStorage.setItem(cartKey, JSON.stringify(cart));
            notyf.success(`${nama} successfully added to your cart.`);
            updateCartUI();
        });
    });
}

function updateCartUI() {
    const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
    const totalItems = cart.reduce((total, item) => total + item.quantity, 0);
    const cartCountElement = document.getElementById('cart-count');
    if (cartCountElement) {
        cartCountElement.textContent = totalItems;
    }
}
</script>

<script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
<script>
  AOS.init({
  });
</script>
</body>
</html>