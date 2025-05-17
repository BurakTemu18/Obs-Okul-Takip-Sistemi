<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Login::index');


$routes->get('/login', 'Login::index');
$routes->post('/login/auth', 'Login::auth');
$routes->get('/logout', 'Login::logout');


$routes->get('/mudur/dashboard', 'Mudur::dashboard');
$routes->get('/ogretmen/dashboard', 'Ogretmen::dashboard');
$routes->get('/ogrenci/dashboard', 'Ogrenci::dashboard');

$routes->get('/mudur/kullanici-ekle', 'Mudur::kullaniciEkle');
$routes->post('/mudur/kullanici-kaydet', 'Mudur::kullaniciKaydet');
$routes->get('/mudur/kullanici-listele', 'Mudur::kullaniciListele');
$routes->get('/mudur/kullanici-sil/(:num)', 'Mudur::kullaniciSil/$1');
$routes->get('/mudur/kullanici-duzenle/(:num)', 'Mudur::kullaniciDuzenle/$1');
$routes->post('/mudur/kullanici-guncelle/(:num)', 'Mudur::kullaniciGuncelle/$1');


$routes->get('/mudur/not-silm/(:num)', 'Mudur::notSilm/$1');
$routes->get('/mudur/devamsizlik-silm/(:num)', 'Mudur::devamsizlikSilm/$1');

$routes->get('/mudur/siniflar', 'Mudur::siniflar');
$routes->get('/mudur/sinif/(:segment)', 'Mudur::sinifDetay/$1');

$routes->get('/ogretmen/not-ekle/(:num)', 'Ogretmen::notEkle/$1');
$routes->post('/ogretmen/not-kaydet', 'Ogretmen::notKaydet');
$routes->get('/ogretmen/devamsizlik-ekle/(:num)', 'Ogretmen::devamsizlikEkle/$1');
$routes->post('/ogretmen/devamsizlik-kaydet', 'Ogretmen::devamsizlikKaydet');
$routes->get('/ogretmen/gecmis', 'Ogretmen::gecmis');

$routes->get('/ogrenci/dashboard', 'Ogrenci::dashboard');


$routes->get('/ogretmen/ogrenci/(:num)', 'Ogretmen::ogrenciBilgi/$1');
$routes->get('/ogretmen/not-sil/(:num)', 'Ogretmen::notSil/$1');
$routes->get('/ogretmen/devamsizlik-sil/(:num)', 'Ogretmen::devamsizlikSil/$1');


