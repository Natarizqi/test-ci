<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

$routes->group('admin', function ($routes) {
    $routes->get('kategori', 'KategoriController::index');
    $routes->post('kategori/store', 'KategoriController::store');
    $routes->get('kategori/edit', 'KategoriController::edit');
    $routes->put('kategori/update', 'KategoriController::update');
    $routes->delete('kategori/delete', 'KategoriController::destroy');
    $routes->post('kategori/list', 'KategoriController::listKategori');

    $routes->get('berita', 'BeritaController::index');
    $routes->post('berita/store', 'BeritaController::store');
    $routes->get('berita/edit', 'BeritaController::edit');
    $routes->put('berita/update', 'BeritaController::update');
    $routes->delete('berita/delete', 'BeritaController::destroy');
});
