<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Tailwind + DaisyUI CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      plugins: [daisyui]
    }
  </script>
  <script src="https://cdn.jsdelivr.net/npm/daisyui@5.3.1/dist/full.js"></script>

  <!-- Notyf -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>

  <title>Login | CampusEats</title>
</head>
<body class="min-h-screen flex flex-col">

  <?= view('partial/navbar-auth-page') ?>

  <div class="flex justify-center items-center flex-1">
    <div class="bg-white shadow-md rounded-xl p-8 w-full max-w-md m-4">
      <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

      <form method="POST" action="<?= base_url('auth/login') ?>" class="space-y-4" id="loginForm">
        <div>
          <label class="label">Username</label>
          <input type="text" name="username" class="input input-bordered w-full rounded-lg border py-1.5" />
        </div>
        <div>
          <label class="label">Password</label>
          <input type="password" name="password" class="input input-bordered w-full rounded-lg border py-1.5" />
        </div>

        <button type="submit" class="btn bg-yellow-400 text-black w-full hover:bg-yellow-600 rounded-lg py-1.5">
          Login
        </button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Don't have an account?
        <a href="<?= base_url('auth/register') ?>" class="text-yellow-600 hover:underline">Register</a>
      </p>
      <p class="mt-4 text-center text-sm text-gray-600">
        Forgot your password?
        <a href="<?= base_url('auth/reset-password') ?>" class="text-yellow-600 hover:underline">Reset Password</a>
      </p>
    </div>
  </div>

  <script>
    const notyf = new Notyf({ duration: 3000, position: { x: 'right', y: 'top' } });

    <?php if (session()->getFlashdata('error')): ?>
      notyf.error("<?= session('error') ?>");
    <?php elseif (session()->getFlashdata('success')): ?>
      notyf.success("<?= session('success') ?>");
    <?php endif; ?>
  </script>

</body>
</html>
