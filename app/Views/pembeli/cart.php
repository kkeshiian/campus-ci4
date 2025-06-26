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
  <title>Cart</title>

  <!-- Midtrans Snap.js -->
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>
  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

  <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
  
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>
</head>
<body class="min-h-screen flex flex-col overflow-y-auto">


  <div class="w-full max-w-4xl mx-auto m-4" data-aos="fade-up" data-aos-duration="1000">
    <h1 class="text-2xl font-bold mb-4 text-center">Your Cart</h1>
    <div id="cartContainer" class="space-y-4 p-4 shadow-md border border-1 border-black rounded-lg mx-4"></div>
  <div class="text-right mt-4 mx-4">
    <p class="text-xl font-semibold">Total: Rp <span id="totalHarga">0</span></p>
    <button id="choosePaymentMethod" class="mt-2 bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
      Choose Payment
    </button>
  </div>  
  </div>
  <!-- Modal Pilihan Pembayaran -->
  <div id="paymentModal" class="hidden fixed inset-0 shadow-xl rounded-lg bg-opacity-10 flex items-center justify-center z-[999999]">
    <div class="bg-gray-100 shadow-xl p-6 rounded-lg w-full max-w-xs text-center">
      <h2 class="text-lg font-bold mb-4">Choose your payment method</h2>
      <div class="flex flex-col space-y-2">
        <button id="checkoutButton" class="mt-2 bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
          Cashless
        </button>
        <button id="payCash" class="mt-2 bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600">
          Cash
        </button>
        <button onclick="closeModal()" class="text-red-500 hover:underline mt-2">Back</button>
      </div>
    </div>
  </div>

  


<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>

<script>
  const idPembeli = <?= json_encode($id_pembeli) ?>;
  const cartKey = `cart_user_${idPembeli}`;

  function loadCart() {
    const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
    const container = document.getElementById('cartContainer');
    const totalHargaElem = document.getElementById('totalHarga');
    container.innerHTML = '';

    if (cart.length === 0) {
      container.innerHTML = '<p class="text-center text-gray-500">Empty.</p>';
      totalHargaElem.textContent = '0';
      document.getElementById('choosePaymentMethod').style.display = 'none';
      return;
    } else {
      document.getElementById('choosePaymentMethod').style.display = 'inline-block';
    }

    let total = 0;

    cart.forEach((item, index) => {
      const subtotal = Math.round(item.harga * item.quantity);
      const kantin = item.kantin;
      total += subtotal;

      const card = document.createElement('div');
      card.className = "flex flex-col md:flex-row items-center justify-between border-b";

      card.innerHTML = `
        <div class="flex flex-col md:flex-row justify-between w-full">
          <div class="flex-1 w-full">
            <h2 class="text-xl font-bold text-gray-800 mb-1">${item.nama}</h2>
            <h2 class="text-xl font-bold text-gray-800 mb-1">${kantin}</h2>
            <p class="text-sm text-gray-700 mb-2">Rp ${item.harga.toLocaleString('id-ID')}</p>
            <input type="text" placeholder="Catatan untuk penjual..." value="${item.notes || ''}" 
              class="border border-gray-300 rounded-lg px-3 py-2 w-full text-sm focus:outline-none focus:ring-1 focus:ring-black note-input mb-3" data-index="${index}" />
            <div class="flex items-center justify-between">
              <div>
                <p class="text-sm text-gray-700">Subtotal: <span class="font-semibold text-black">Rp ${subtotal.toLocaleString('id-ID')}</span></p>
                <button class="delete-item text-sm text-red-600 hover:text-red-800 hover:underline transition" data-index="${index}">Delete</button>
              </div>
              <div class="flex items-center gap-2">
                <button class="decrease h-6 w-6 border border-black text-black flex items-center justify-center rounded-full hover:bg-kuning transition" data-index="${index}">−</button>
                <span class="text-base font-semibold w-6 text-center">${item.quantity}</span>
                <button class="increase h-6 w-6 border border-black text-black flex items-center justify-center rounded-full hover:bg-kuning transition" data-index="${index}">+</button>
              </div>
            </div>
          </div>
        </div>
      `;
      container.appendChild(card);
    });

    totalHargaElem.textContent = total.toLocaleString('id-ID');
  }

  function getFormattedCart() {
    const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
    return cart.map(item => ({
      id: item.id,
      nama_menu: item.nama,
      harga: item.harga,
      quantity: item.quantity,
      notes: item.notes || '',
      nama_kantin: item.kantin
    }));
  }

  function generateOrderID() {
    return "ORD" + Date.now() + Math.floor(Math.random() * 1000);
  }

  function getCartTotal(cart) {
    return Math.round(cart.reduce((sum, item) => sum + item.harga * item.quantity, 0));
  }

  // Event handler: tombol +, -, delete
  document.addEventListener('click', function(e) {
    const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
    const index = parseInt(e.target.dataset.index);

    if (e.target.classList.contains('increase')) {
      cart[index].quantity += 1;
    } else if (e.target.classList.contains('decrease')) {
      if (cart[index].quantity > 1) cart[index].quantity -= 1;
    } else if (e.target.classList.contains('delete-item')) {
      cart.splice(index, 1);
    } else {
      return;
    }

    localStorage.setItem(cartKey, JSON.stringify(cart));
    loadCart();
  });

  // Catatan / notes
  document.addEventListener('input', function(e) {
    if (e.target.classList.contains('note-input')) {
      const index = parseInt(e.target.dataset.index);
      const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
      cart[index].notes = e.target.value;
      localStorage.setItem(cartKey, JSON.stringify(cart));
    }
  });

  // Checkout cashless
  const checkoutButton = document.getElementById('checkoutButton');
  checkoutButton.addEventListener('click', function () {
    const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
    if (cart.length === 0) {
      alert("Keranjang kosong.");
      return;
    }

    const formattedCart = getFormattedCart();
    const total = getCartTotal(cart);
    const order_id = generateOrderID();

    checkoutButton.disabled = true;

    fetch("<?= base_url('midtrans/getToken') ?>", {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        order_id: order_id,
        gross_amount: total,
        items: formattedCart,
        id_pembeli: idPembeli,
        tipe: "cashless",
        status_pembayaran: "paid"
      })
    })
    .then(res => res.json())
    .then(data => {
      if (data.token) {
        snap.pay(data.token, {
          onSuccess: function(result) {
            fetch('/pembeli/save-order', {
              method: 'POST',
              headers: {'Content-Type': 'application/json'},
              body: JSON.stringify({
                order_id: order_id,
                id_pembeli: idPembeli,
                cart: formattedCart,
                tipe: "cashless",
                status_pembayaran: "paid"
              })
            })
            .then(res => res.json())
            .then(response => {
              if (response.success) {
                localStorage.removeItem(cartKey);
                window.location.href = "/pembeli/order-success?order_id=" + order_id + "&id_pembeli=" + idPembeli;
              } else {
                alert("Gagal menyimpan pesanan.");
              }
            });
          },
          onPending: () => alert("Menunggu pembayaran."),
          onError: () => alert("Pembayaran gagal.")
        });
      } else {
        alert("Gagal mendapatkan token Midtrans.");
        checkoutButton.disabled = false;
      }
    })
    .catch(err => {
      console.error(err);
      alert("Terjadi kesalahan.");
      checkoutButton.disabled = false;
    });
  });

  // Cash flow
  document.getElementById('choosePaymentMethod').addEventListener('click', function () {
    document.getElementById('paymentModal').classList.remove('hidden');
  });

  function closeModal() {
    document.getElementById('paymentModal').classList.add('hidden');
  }

  document.getElementById('payCash').addEventListener('click', function () {
    closeModal();
    handleCashPayment();
  });

  function handleCashPayment() {
    const cart = JSON.parse(localStorage.getItem(cartKey)) || [];
    if (cart.length === 0) {
      alert("Keranjang kosong.");
      return;
    }

    const formattedCart = getFormattedCart();
    const total = getCartTotal(cart);
    const order_id = generateOrderID();

    fetch('/pembeli/save-order', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({
        order_id: order_id,
        id_pembeli: idPembeli,
        cart: formattedCart,
        tipe: "cash",
        status_pembayaran: "pending"
      })
    })
    .then(res => res.json())
    .then(data => {
      localStorage.removeItem(cartKey);
      window.location.href = "order-success?order_id=" + order_id + "&id_pembeli=" + idPembeli;
    })
    .catch(err => {
      console.error(err);
      alert("Gagal menyimpan pesanan cash.");
    });
  }

  loadCart();
</script>

<script>
  AOS.init({});
</script>

</body>
</html>