<?php

namespace Config;

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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->get('/admin/dashboard', 'Admin\Dashboard::index');
$routes->get('/admin/transaksi', 'Admin\Transaksi::index', ['filter' => 'permission:access_transaction']);
$routes->get('/admin/kategori', 'Admin\Kategori::index', ['filter' => 'permission:access_product']);
$routes->add('/admin/kategori/tambah', 'Admin\Kategori::tambah');
$routes->add('/admin/kategori/edit/(:num)', 'Admin\Kategori::edit/$1');
$routes->add('/admin/kategori/hapus/(:num)', 'Admin\Kategori::hapus/$1');
$routes->get('/admin/kategori/sampah', 'Admin\Kategori::sampah');
$routes->get('/admin/satuan', 'Admin\Satuan::index', ['filter' => 'permission:access_product']);
$routes->add('/admin/satuan/tambah', 'Admin\Satuan::tambah');
$routes->add('/admin/satuan/edit/(:num)', 'Admin\Satuan::edit/$1');
$routes->add('/admin/satuan/hapus/(:num)', 'Admin\Satuan::hapus/$1');
$routes->get('/admin/satuan/sampah', 'Admin\Satuan::sampah');
$routes->get('/admin/member', 'Admin\Member::index');
$routes->add('/admin/member/tambah', 'Admin\Member::tambah', ['filter' => 'permission:access_customer']);
$routes->add('/admin/member/edit/(:num)', 'Admin\Member::edit/$1');
$routes->add('/admin/member/hapus/(:num)', 'Admin\Member::hapus/$1');
$routes->get('/admin/member/sampah', 'Admin\Member::sampah');
$routes->get('/admin/produk', 'Admin\Produk::index', ['filter' => 'permission:access_product']);
$routes->get('/admin/produk/tambah', 'Admin\Produk::tambah');
$routes->get('/admin/produk/edit/(:num)', 'Admin\Produk::edit/$1');
$routes->get('/admin/produk/hapus/(:num)', 'Admin\Produk::hapus/$1');
$routes->get('/admin/produk/sampah', 'Admin\Produk::sampah');
$routes->get('/admin/supplier', 'Admin\Supplier::index', ['filter' => 'permission:access_supplier']);
$routes->add('/admin/supplier/tambah', 'Admin\Supplier::tambah');
$routes->add('/admin/supplier/edit/(:num)', 'Admin\Supplier::edit/$1');
$routes->add('/admin/supplier/hapus/(:num)', 'Admin\Supplier::hapus/$1');
$routes->get('/admin/supplier/sampah', 'Admin\Supplier::sampah');
$routes->get('/admin/stock/in', 'Admin\Stok::stockIn', ['filter' => 'permission:access_stock']);
$routes->add('/admin/stock/in/tambah', 'Admin\Stok::stockInAdd');
$routes->add('/admin/stock/in/hapus/(:num)', 'Admin\Stok::stockInDelete/$1');
$routes->get('/admin/stock/out', 'Admin\Stok::stockOut', ['filter' => 'permission:access_stock']);
$routes->add('/admin/stock/out/tambah', 'Admin\Stok::stockOutAdd');
$routes->add('/admin/stock/out/hapus/(:num)', 'Admin\Stok::stockOutDelete/$1');
$routes->add('/admin/laporan/penjualan', 'Admin\LaporanPenjualan::index');
$routes->add('/admin/laporan/detailpenjualan', 'Admin\LaporanDetPenjualan::index');
$routes->add('/admin/laporan/stock', 'Admin\Stok::index');

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
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
