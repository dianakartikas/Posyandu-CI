<?php

namespace Config;

use CodeIgniter\Router\Router;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * -------- ------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

//$routes->get('/', 'Warga::profile');

$routes->get('/admin', 'Admin::index', ['filter' => 'role:admin']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
$routes->get('/imunisasi', 'Imunisasi::index', ['filter' => 'role:admin']);
// $routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
$routes->get('/cetakimunisasi/export', 'Home::exportimunisasi', ['filter' => 'role:admin']);
$routes->get('/cetakimunisasi', 'Home::cetakimunisasi', ['filter' => 'role:admin']);
$routes->get('/cetakpertumbuhan/export', 'Home::exportpertumbuhan', ['filter' => 'role:admin']);
$routes->get('/cetakpertumbuhan', 'Home::cetakpertumbuhan', ['filter' => 'role:admin']);
$routes->get('/cetakgagalperiksa/export', 'Home::exportgagalperiksa', ['filter' => 'role:admin']);
$routes->get('/cetakgagalperiksa', 'Home::cetakgagalPemeriksaan', ['filter' => 'role:admin']);
$routes->get('/cetaktidakberkunjung/export', 'Home::exporttidakberkunjung', ['filter' => 'role:admin']);
$routes->get('/cetaktidakberkunjung', 'Home::cetaktidakberkunjung', ['filter' => 'role:admin']);
$routes->get('/datapemeriksaan', 'CekImunisasi::datapemeriksaan', ['filter' => 'role:kader']);
$routes->get('/pemeriksaanAnak', 'Warga::datapemeriksaan', ['filter' => 'role:user']);
$routes->get('/admin/(:num)', 'Admin::detail/$1', ['filter' => 'role:admin']);
// $routes->delete('/admin/(:num)', 'admin::delete/$1');
// $routes->get('/', 'Warga::index', ['filter' => 'role:kader']);
$routes->get('/warga', 'Warga::index', ['filter' => 'role:kader']);
$routes->get('/admin/confirmdelete/(:num)', 'admin::confirmdelete/$1');
$routes->get('/warga/detail/(:num)/hapus/(:num)', 'warga::hapus/$1');

$routes->get('/warga/(:num)', 'Warga::detail/$1', ['filter' => 'role:kader']);
$routes->get('/kms/(:num)', 'Kms::detail/$1', ['filter' => 'role:kader']);

$routes->get('/anak', 'Anak::index', ['filter' => 'role:user']);
$routes->get('/', 'Home::index', ['filter' => 'login']);
$routes->get('/antrian', 'Kunjungan::AntrianByWarga', ['filter' => 'role:user']);
$routes->get('/kunjungan/(:num)', 'Kunjungan::tambahAntrian/$1', ['filter' => 'role:kader']);
$routes->get('/password', 'Admin::password', ['filter' => 'login']);
$routes->get('/profile', 'Admin::profile', ['filter' => 'login']);
$routes->get('/cekimunisasi', 'CekImunisasi::index', ['filter' => 'role:kader']);
$routes->get('/pertumbuhan', 'CekPertumbuhan::index', ['filter' => 'role:kader']);
$routes->get('/cekimunisasi/(:num)', 'CekImunisasi::cekimunisasi/$1', ['filter' => 'role:kader']);
$routes->get('/pertumbuhan/(:num)', 'CekPertumbuhan::pertumbuhan/$1', ['filter' => 'role:kader']);
$routes->get('/periksa/(:num)', 'CekPertumbuhan::periksa/$1', ['filter' => 'role:kader']);
// $routes->get('/', 'Warga::index', ['filter' => 'noauth']);
// $routes->get('logout', 'Warga::logout');
// $routes->match(['get', 'post'], 'daftar', 'Warga::daftar', ['filter' => 'noauth']);

// $routes->get('dashboard', 'Dashboard::index', ['filter' => 'auth']);



//$routes->get('/admin/beranda(:segment)', 'Admin/Beranda::edit/$1');
//$routes->get('anak', 'Anak::save', ['filter' => 'auth']);
//$routes->add('/dashboard/save', 'Dashboard::index', ['filter' => 'auth']);


/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
