<div class="navbar bg-base-100 px-10 py-4 items-center flex justify-between">
  <div class="navbar-start">
    <div class="flex-1">
      <a class="btn btn-ghost normal-case text-xl hover:text-2xl" href="<?= base_url('/auth/login') ?>">CampusEats</a>
    </div>
  </div>

  <div class="navbar-end flex items-center gap-4 z-10 flex-end">
    <div class="flex gap-2">
      <a href="<?= base_url('auth/login') ?>"
        class="bg-yellow-500 text-white py-2 px-4 rounded hover:bg-yellow-600 transition mr-4">
        Login
      </a>
      <a href="<?= base_url('auth/register') ?>"
        class="text-yellow-500 border border-yellow-500 py-2 px-4 rounded hover:bg-yellow-100 transition">
        Register
      </a>
    </div>
  </div>
</div>
