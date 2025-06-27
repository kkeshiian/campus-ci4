<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <link href="/campuseats/dist/output.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;400;600&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
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
  <?= view('partial/navbar-belum-login') ?>

  <div class="flex justify-center items-center flex-1">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-md m-4">
      <h2 class="text-2xl font-bold mb-2 text-center">Reset Your Password</h2>
      <p class="text-base mb-6 text-center text-gray-600">
        Enter your email address and we’ll send you a verification code.
      </p>

      <form method="POST" action="<?= base_url('auth/send-reset-link') ?>" class="space-y-4">
        <?= csrf_field() ?>
        <div>
          <label class="label">Email</label>
          <input
            type="email"
            name="email"
            value="<?= old('email') ?>"
            class="input input-bordered w-full rounded-lg border-2"
            required
          />
        </div>

        <button type="submit" class="btn bg-yellow-400 text-black w-full hover:bg-yellow-600 rounded-lg">
          Send OTP Code
        </button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <script>
    const notyf = new Notyf({
      duration: 2500,
      position: { x: 'right', y: 'top' },
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

    <?php if (session()->getFlashdata('success')): ?>
      notyf.success("<?= esc(session('success')) ?>");
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
      notyf.error("<?= esc(session('error')) ?>");
    <?php endif; ?>

    <?php if (session()->getFlashdata('errors')): ?>
      <?php foreach ((array)session()->getFlashdata('errors') as $err): ?>
        notyf.error("<?= esc($err) ?>");
      <?php endforeach; ?>
    <?php endif; ?>
  </script>
</body>
</html>
