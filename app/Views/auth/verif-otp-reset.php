<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/daisyui@5.3.1/dist/full.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <title>Verif Yout Accout | CampusEats</title>

  <!-- Notyf CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
</head>
<body class="min-h-screen flex flex-col">

    <?= view('partial/navbar-belum-login') ?>
    
  <div class="flex justify-center items-center flex-1">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-xl m-4">
      <h2 class="text-2xl font-bold mb-2 text-center">Verification OTP Code</h2>
      <h5 class="text-lg mb-6 text-center">We have sent an OTP code to your email. Please check your inbox and enter the code below.</h5>
    <form method="POST" class="space-y-6" id="otpForm" action="<?= base_url('auth/verif-otp-reset') ?>">
        <h3 class="text-2xl font-bold text-center">OTP Code</h3>

    <div class="w-full flex justify-center">
    <input
        type="text"
        name="otp"
        maxlength="8"
        inputmode="text"
        class="w-40 h-14 text-center text-2xl p-2 tracking-widest border border-gray-300 rounded-xl shadow-sm focus:outline-none focus:ring-2 focus:ring-yellow-400 focus:border-yellow-500 uppercase"
        placeholder="--------"
        required
    />
    </div>
        <button
            type="submit"
            name="submit"
            class="btn bg-yellow-200 w-full flex justify-center text-black w-40 hover:bg-yellow-600 rounded-lg"
        >
            Verify
        </button>
    </form>
    <p class="mt-4 text-center text-sm text-gray-600">
        Did not receive the code?
        <a href="/auth/verif-otp-reset-resend?resend=true" class="text-yellow-600 hover:underline">Resend OTP</a>
    </p>
    </div>
  </div>

  <!-- Notyf JS -->
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script>
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

        const urlParams = new URLSearchParams(window.location.search);
        const successParam = urlParams.get('success');
        const resentParam = urlParams.get('resent');

        if (successParam === 'true') {
            notyf.success('Registration successful! Please verify your account.');
        }

        if (resentParam === 'success') {
            notyf.success('OTP has been resent!');
        }

        if (resentParam === 'failed') {
            notyf.error('Failed to resend OTP. Please try again.');
        }

        urlParams.delete('success');
        urlParams.delete('resent');
        const newUrl = window.location.pathname + (urlParams.toString() ? '?' + urlParams.toString() : '');
        window.history.replaceState({}, document.title, newUrl);

        <?php if (session('error') === 'wrong_credentials'): ?>
        notyf.error('Incorrect OTP Code!');
        <?php elseif (session('error') === 'empty_fields'): ?>
        notyf.error('Please fill in all fields!');
        <?php endif; ?>


  </script>

</body>
</html>