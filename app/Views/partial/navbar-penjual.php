<?php
$id_penjual = isset($_SESSION['id_penjual']) ? $_SESSION['id_penjual'] : null;
$activePage = isset($activePage) ? $activePage : '';
?>

<!-- Include SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="sticky top-0 z-50 bg-base-100 shadow-sm navbar">
  <div class="navbar-start">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" /> 
        </svg>
      </div>
      <ul tabindex="0" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-50 mt-3 w-52 p-2 shadow">
        <li><a href="/penjual/dashboard<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'dashboard_seller') ? 'underline decoration-yellow decoration-1 underline-offset-4 ' :  '' ?>">Dashboard</a></li>
        <li><a href="/penjual/kelola-menu<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'manage_menu_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Manage Menu</a></li>
        <li><a href="/penjual/kelola-kantin<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'manage_canteen_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Manage Canteen</a></li>
        <li><a href="/penjual/laporan-penjualan<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'laporan_penjualan') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Sales Report</a></li>
      </ul>
    </div>
    <a class="btn btn-ghost normal-case text-xl">CampusEats</a>
  </div>

  <div class="navbar-center hidden lg:flex">
    <ul class="menu menu-horizontal px-1">
      <li><a href="/penjual/dashboard<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'dashboard_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4 ' :  '' ?>">Dashboard</a></li>
      <li><a href="/penjual/kelola-menu<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'manage_menu_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Manage Menu</a></li>
      <li><a href="/penjual/kelola-kantin<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'manage_canteen_seller') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Manage Canteen</a></li>
      <li><a href="/penjual/laporan-penjualan<?= $id_penjual ? '?id_penjual=' . $id_penjual : '' ?>" class="<?= ($activePage == 'laporan_penjualan') ? 'underline decoration-kuning decoration-1 underline-offset-4' :  '' ?>">Sales Report</a></li>
    </ul>
  </div>

  <div class="navbar-end flex items-center gap-4 z-10">
    <!-- Tombol Logout -->
    <button id="logoutBtn" class="bg-kuning text-white p-2 px-4 rounded hover:bg-yellow-600 transition">
      Logout
    </button>
  </div>
</div>

<!-- SweetAlert Logout Script -->
<script>
  document.getElementById('logoutBtn').addEventListener('click', function(e) {
    e.preventDefault();
    Swal.fire({
      title: 'Logout Confirmation',
      text: "Are you sure you want to logout?",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#FFB43B',
      confirmButtonText: 'Yes, logout',
      cancelButtonText: 'Cancel'
    }).then((result) => {
      if (result.isConfirmed) {
        window.location.href = "/campuseats/pages/auth/logout.php";
      }
    });
  });
</script>
