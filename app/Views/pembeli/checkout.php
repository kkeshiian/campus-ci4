<?php
require_once '../../middleware/role_auth.php';

require_role('pembeli');
?>
<?php session_start(); ?>


<!DOCTYPE html>
<html>
<head>
  <title>Checkout</title>
  <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="SB-Mid-client-eQfKe1LFpAFOWEcr"></script>
</head>
<body>
  <h2>Checkout</h2>
  <p>Order ID: <?= $_SESSION['order_id'] ?></p>
  <p>Total: Rp <?= number_format($_SESSION['total']) ?></p>

  <button id="pay-button">Bayar Sekarang</button>

  <script>
    document.getElementById('pay-button').addEventListener('click', function () {
      fetch('../../api/get-midtrans-token.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          order_id: "<?= $_SESSION['order_id'] ?>",
          gross_amount: <?= $_SESSION['total'] ?>
        })
      })
      .then(res => res.json())
      .then(data => {
        snap.pay(data.token, {
          onSuccess: function () {
            window.location.href = "order-success.php";
          },
          onPending: function () {
            alert("Menunggu pembayaran");
          },
          onError: function () {
            alert("Pembayaran gagal");
          }
        });
      });
    });
  </script>
</body>
</html>