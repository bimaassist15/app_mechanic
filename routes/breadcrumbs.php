<?php 
use Diglactic\Breadcrumbs\Breadcrumbs;


use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', url('home'));
});

// Home > kategori
Breadcrumbs::for('kategori', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('kategori', url('master/kategori'));
});

// Home > satuan
Breadcrumbs::for('satuan', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('satuan', url('master/satuan'));
});

// Home > barang
Breadcrumbs::for('barang', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('barang', url('master/barang'));
});

// Home > customer
Breadcrumbs::for('customer', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('customer', url('master/customer'));
});
// Home > kendaraan
Breadcrumbs::for('kendaraan', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('kendaraan', url('master/kendaraan'));
});
// Home > supplier
Breadcrumbs::for('supplier', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('supplier', url('master/supplier'));
});
// Home > kategoriServis
Breadcrumbs::for('kategoriServis', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Kategori Service', url('master/kategoriServis'));
});
// Home > hargaServis
Breadcrumbs::for('hargaServis', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Harga Service', url('master/hargaServis'));
});