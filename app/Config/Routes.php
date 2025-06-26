<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LandingController::index');
$routes->post('midtrans/token', 'Midtrans::getToken');
$routes->post('midtrans/callback', 'Midtrans::callback');
$routes->get('/penjual/dashboard', 'PenjualController::dashboard', ['filter' => 'role:penjual']);


$routes->group('pembeli', ['filter' => 'role:pembeli'], function($routes) {
    $routes->get('about-us', 'PembeliController::aboutUs');
    $routes->get('canteen', 'PembeliController::canteen');
    $routes->get('cart', 'PembeliController::cart');
    $routes->get('checkout', 'PembeliController::checkout');
    $routes->get('history', 'PembeliController::history');
    $routes->get('invoice', 'PembeliController::invoice');
    $routes->get('menu', 'PembeliController::menu');
    $routes->get('order-success', 'PembeliController::orderSuccess');
    $routes->get('profile', 'PembeliController::profile');

    $routes->post('proses-kelola-profile', 'PembeliController::prosesKelolaProfile');
    $routes->post('save-order', 'PembeliController::saveOrder');
});

$routes->group('penjual', ['filter' => 'role:penjual'], function($routes) {
    $routes->get('dashboard', 'PenjualController::dashboard');
    $routes->get('edit-menu', 'PenjualController::editMenu');
    $routes->get('hapus-menu', 'PenjualController::hapusMenu');


    $routes->get('history', 'PenjualController::history');
    $routes->get('kelola-kantin', 'PenjualController::kelolaKantin');
    $routes->get('kelola-menu', 'PenjualController::kelolaMenu');
    $routes->get('laporan-penjualan', 'PenjualController::laporanPenjualan');
    $routes->get('report-problem', 'PenjualController::reportProblem');
    $routes->get('tambah-menu', 'PenjualController::tambahMenu');
    $routes->get('proses-hapus-menu/(:num)', 'PenjualController::prosesHapusMenu/$1');


    $routes->post('proses-edit-menu', 'PenjualController::prosesEditMenu');
    $routes->post('proses-hapus-menu', 'PenjualController::prosesHapusMenu');
    $routes->post('proses-kelola-kantin', 'PenjualController::prosesKelolaKantin');
    $routes->post('proses-report', 'PenjualController::prosesReport');
    $routes->post('proses-tambah-menu', 'PenjualController::prosesTambahMenu');
    $routes->post('edit-menu', 'PenjualController::editMenu');
});

$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    $routes->get('dashboard', 'AdminController::dashboard');
    $routes->get('edit-data-pembeli', 'AdminController::editDataPembeli');
    $routes->get('hapus-report', 'AdminController::hapusReport');
    $routes->get('hapus-pembeli', 'AdminController::hapusPembeli');
    $routes->get('kelola-kantin', 'AdminController::kelolaKantin');
    $routes->get('kelola-pengguna', 'AdminController::kelolaPengguna');
    $routes->get('kelola-report', 'AdminController::kelolaReport');
    $routes->get('register-penjual', 'AdminController::registerPenjual');
    $routes->get('tambah-kantin', 'AdminController::tambahKantin');

    $routes->get('profile', 'AdminController::editProfile');
    $routes->post('profile', 'AdminController::updateProfile');

    $routes->get('tambahKantin/(:num)', 'AdminController::tambahKantin/$1');
    $routes->post('simpanKantin', 'AdminController::simpanKantin');
});


$routes->match(['get', 'post'], 'auth/login', 'AuthController::login');
$routes->match(['get', 'post'], 'auth/register', 'AuthController::register');
$routes->match(['get', 'post'], 'auth/verif-otp', 'AuthController::verifOtp');
$routes->get('/pembeli/menu', 'PembeliController::menu');
$routes->get('/pembeli/logout', 'AuthController::logout');
$routes->get('/pembeli/cart', 'PembeliController::cart');
$routes->post('/midtrans/getToken', 'Midtrans::getToken');
$routes->post('/midtrans/callback', 'Midtrans::callback');
$routes->get('pembeli/order-success', 'PembeliController::orderSuccess');
$routes->get('pembeli/history', 'PembeliController::history');
$routes->post('/pembeli/save-order', 'PembeliController::saveOrder');
$routes->get('/pembeli/about_us', 'PembeliController::aboutUs');
$routes->get('/pembeli/history', 'PembeliController::history');
$routes->post('/penjual/update-status', 'PenjualController::updateStatusPesanan');

$routes->get('penjual/tambah-menu', 'PenjualController::tambahMenu');
$routes->post('penjual/proses-tambah-menu', 'PenjualController::prosesTambahMenu');
$routes->get('penjual/kelola-kantin', 'PenjualController::kelolaKantin');
$routes->post('penjual/proses-kelola-kantin', 'PenjualController::prosesKelolaKantin');
$routes->get('laporan-penjualan', 'PenjualController::laporanPenjualan');

$routes->get('admin/editDataPembeli/(:num)', 'AdminController::editDataPembeli/$1');
$routes->post('admin/editDataPembeli/(:num)', 'AdminController::updateDataPembeli/$1');

$routes->get('admin/hapusPembeli/(:num)/(:num)', 'AdminController::hapusPembeli/$1/$2');

$routes->match(['get', 'post'], 'admin/editDataPenjual/(:num)/(:num)', 'AdminController::editDataPenjual/$1/$2');
$routes->match(['get', 'post'], 'admin/hapusKantin/(:num)/(:num)', 'AdminController::hapusKantin/$1/$2');