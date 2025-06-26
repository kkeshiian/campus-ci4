<!DOCTYPE html>
<html data-theme="light" class="bg-background">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/daisyui@5.3.1/dist/full.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <title>Register | CampusEats</title>
</head>

<body class="min-h-screen flex flex-col relative">
  
  <?= view('partial/navbar-auth-page') ?>

  <div class="flex justify-center items-center flex-1 mb-10 mt-14">
    <div class="bg-white shadow-md border border-black rounded-2xl p-8 w-full max-w-md">
      <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

      <form method="POST" action="<?= base_url('auth/register') ?>" class="space-y-4" novalidate>
        <?= csrf_field() ?>
        <div class="form-control">
          <label class="label" for="nama">Full Name</label>
          <input id="nama" type="text" name="nama" value="<?= old('nama') ?>" class="input input-bordered w-full rounded-lg py-1 border" />
        </div>
        <div class="form-control">
          <label class="label">Email</label>
          <input type="email" name="email" value="<?= old('email') ?>" class="input input-bordered w-full rounded-lg py-1 border" />
        </div>
        <div class="form-control">
          <label class="label">Username</label>
          <input type="text" name="username" value="<?= old('username') ?>" class="input input-bordered w-full rounded-lg py-1 border" />
        </div>
        <div class="form-control">
          <label class="label">Whatsapp Number</label>
          <input type="text" name="nomor_wa" value="<?= old('nomor_wa') ?>" class="input input-bordered w-full rounded-lg py-1 border" />
        </div>
        <div class="form-control">
          <label class="label">Password</label>
          <input type="password" name="password" class="input input-bordered w-full rounded-lg py-1 border" />
        </div>
        <div class="form-control">
          <label class="label">Confirm Password</label>
          <input type="password" name="konfirmasi_password" class="input input-bordered w-full rounded-lg py-1 border" />
        </div>

        <button type="submit" class="btn bg-yellow-500 text-black w-full hover:bg-yellow-600 rounded-lg py-1.5">Register</button>
      </form>

      <p class="mt-4 text-center text-sm text-gray-600">
        Already have an account? 
        <a href="<?= base_url('auth/login') ?>" class="text-yellow-600 hover:underline">Login</a>
      </p>
    </div>
  </div>

  <script>
    const notyf = new Notyf({ duration: 3000, position: { x: 'right', y: 'top' } });
    <?php if (session()->getFlashdata('error')): ?>
      notyf.error("<?= esc(session('error')) ?>");
    <?php elseif (session()->getFlashdata('success')): ?>
      notyf.success("<?= esc(session('success')) ?>");
    <?php endif; ?>
  </script>


</body>
</html>