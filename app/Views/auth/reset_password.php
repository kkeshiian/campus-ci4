<?= view('partial/navbar-belum-login') ?>

<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <script src="https://cdn.jsdelivr.net/npm/daisyui@4.10.2/dist/full.js"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />

    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
</head>

<body class="min-h-screen flex flex-col">
   
  <div class="flex justify-center items-center flex-1">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-md m-4">
    <h2 class="text-2xl font-bold mb-2 text-center">Reset Your Password</h2>
    <p class="text-base mb-6 text-center text-gray-600">
    Enter your new password here!
    </p>

      <form method="POST" action="/auth/reset-password/" class="space-y-4">
        <div>
          <label class="label">New Password</label>
          <input type="password" required name="password" class="input input-bordered w-full rounded-lg border-2" />
        </div>
        <div>
          <label class="label">Confirmation Your New Password</label>
          <input type="password" required name="konfirmasi_password" class="input input-bordered w-full rounded-lg border-2" />
          <p class="text-gray-500 mt-1 text-xs leading-snug">
            Password must be at least 8 characters, include uppercase, lowercase, a number,
            and a special symbol (e.g., !@#$%^&*).
          </p>
        </div>

        <button type="submit" name="submit" class="btn bg-kuning text-black w-full hover:bg-yellow-600 rounded-lg">
          Set your new password
        </button>
      </form>
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

    if (successParam == 'true') {
      notyf.success('Reset your password.');
      const url = new URL(window.location);
      url.searchParams.delete('success');
      window.history.replaceState({}, document.title, url.pathname);

    }
    <?php if (!empty($error)): ?>
    notyf.error(<?= json_encode($error) ?>);
    <?php elseif (!empty($success)): ?>
    notyf.success(<?= json_encode($success) ?>);
    <?php endif; ?>

  </script>

</body>
</html>
