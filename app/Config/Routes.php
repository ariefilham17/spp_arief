<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

/*
 * --------------------------------------------------------------------
 * Modules
 * --------------------------------------------------------------------
 */
$routes->get('/', 'Dashboard::index', ['filter' => 'auth']);
$routes->get('/auth', 'Auth::index');
$routes->get('/auth/logout', 'Auth::logout');
$routes->get('/test', 'Home::test', ['filter' => 'auth']);
$routes->get('/jurusan', 'Jurusan::index', ['filter' => 'auth']);
$routes->get('/kelas', 'Kelas::index', ['filter' => 'auth']);
$routes->get('/jenis-biaya', 'Jenis_biaya::index', ['filter' => 'auth']);
$routes->get('/jenis-siswa', 'Jenis_siswa::index', ['filter' => 'auth']);
$routes->get('/biaya', 'Biaya::index', ['filter' => 'auth']);
$routes->get('/kategori', 'Kategori::index', ['filter' => 'auth']);
$routes->get('/siswa', 'Siswa::index', ['filter' => 'auth']);
$routes->get('/administrator', 'Administrator::index', ['filter' => 'auth']);
$routes->get('/pembayaran', 'Pembayaran::index', ['filter' => 'auth']);
$routes->get('/pengeluaran', 'Pengeluaran::index', ['filter' => 'auth']);
$routes->get('/pemasukan', 'Pemasukan::index', ['filter' => 'auth']);
$routes->get('/pembayaran/bulanan', 'Pembayaran::bulanan', ['filter' => 'auth']);
$routes->get('/pembayaran/lainnya', 'Pembayaran::lainnya', ['filter' => 'auth']);
$routes->get('/laporan/keuangan', 'Laporan::keuangan', ['filter' => 'auth']);
$routes->get('/laporan/print/(:any)', 'Laporan::print/$1', ['filter' => 'auth']);
$routes->get('/pembayaran/nota/(:any)', 'Pembayaran::nota/$1', ['filter' => 'auth']);
$routes->get('/setting', 'Setting::index', ['filter' => 'auth']);



/*
 * --------------------------------------------------------------------
 * API
 * --------------------------------------------------------------------
 */
$routes->resource('api/jurusan');
$routes->resource('api/kelas');
$routes->resource('api/jenis_biaya');
$routes->resource('api/jenis_siswa');
$routes->resource('api/kategori');
$routes->resource('api/biaya');
$routes->resource('api/pengeluaran');
$routes->resource('api/pemasukan');

$routes->resource('api/administrator', ['except' => 'show']);
$routes->get('api/administrator/edit/(:num)', 'Api\Administrator::edit/$1');
$routes->post('api/administrator/pass/(:num)', 'Api\Administrator::updatePassword/$1');

$routes->resource('api/auth', ['except' => 'show']);
$routes->post('api/auth/login', 'Api\Auth::login');

$routes->resource('api/siswa', ['except' => 'show']);
$routes->get('api/siswa/detail/(:num)', 'Api\Siswa::detail/$1');
$routes->get('api/siswa/profil/(:num)', 'Api\Siswa::profil/$1');


$routes->resource('api/pembayaran', ['except' => 'show']);
$routes->get('api/pembayaran/detail/(:num)', 'Api\Pembayaran::detail/$1');
$routes->get('api/pembayaran/kelas', 'Api\Pembayaran::kelas');
$routes->get('api/pembayaran/siswa', 'Api\Pembayaran::siswa');
$routes->post('api/pembayaran/tagihan', 'Api\Pembayaran::tagihan');
$routes->post('api/pembayaran/lainnya', 'Api\Pembayaran::lainnya');
$routes->post('api/pembayaran/bayar_bulanan', 'Api\Pembayaran::bayar_bulanan');
$routes->post('api/pembayaran/bayar_lainnya', 'Api\Pembayaran::bayar_lainnya');


$routes->resource('api/laporan', ['except' => 'show']);
$routes->post('api/laporan/keuangan', 'Api\Laporan::keuangan');

$routes->get('api/master/provinsi', 'Api\Master::provinsi');

$routes->post('api/setting/update', 'Api\Setting::update_setting');

$routes->resource('api/dashboard');

/*
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
if (is_file(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
    require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
