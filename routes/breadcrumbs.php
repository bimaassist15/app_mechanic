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

// Home > serial barang
Breadcrumbs::for('serialBarang', function (BreadcrumbTrail $trail) {
    $trail->parent('barang');
    $trail->push('Serial Barang', url('master/serialBarang?barang_id=' . request()->query('barang_id')));
});

// Home > generate barang
Breadcrumbs::for('generateBarang', function (BreadcrumbTrail $trail) {
    $trail->parent('barang');
    $trail->push('Generate Barang', url('master/generateBarang?barang_id=' . request()->query('barang_id')));
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
// Home > cabang
Breadcrumbs::for('cabang', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Cabang', url('master/cabang'));
});
// Home > user
Breadcrumbs::for('user', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('User', url('master/user'));
});
// Home > backup
Breadcrumbs::for('backup', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Backup', url('master/backup'));
});
// Home > restore
Breadcrumbs::for('restore', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Restore', url('master/restore'));
});
// Home > kasir
Breadcrumbs::for('kasir', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Kasir', url('purchase/kasir'));
});
// Home > penjualan
Breadcrumbs::for('penjualan', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Penjualan', url('purchase/penjualan'));
});

// Home > belumLunas
Breadcrumbs::for('belumLunas', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Belum Lunas', url('purchase/belumLunas'));
});
// Home > lunas
Breadcrumbs::for('lunas', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Belum Lunas', url('purchase/lunas'));
});

// Home > kasir
Breadcrumbs::for('kasirTransaction', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Kasir', url('transaction/kasir'));
});
// Home > pembelian
Breadcrumbs::for('pembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Pembelian', url('transaction/pembelian'));
});

// Home > belumLunas
Breadcrumbs::for('belumLunasTransaction', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Belum Lunas', url('transaction/belumLunas'));
});
// Home > lunas
Breadcrumbs::for('lunasTransaction', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Lunas', url('transaction/lunas'));
});
// Home > transferStock
Breadcrumbs::for('transferStock', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Transfer Stok', url('transferstock/stock'));
});
// Home > stokmasuk
Breadcrumbs::for('stokmasuk', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Stok Masuk', url('stokmasuk/stock'));
});
// Home > stokkeluar
Breadcrumbs::for('stokkeluar', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Stok Keluar', url('stokkeluar/stock'));
});
// Home > penerimaanServis
Breadcrumbs::for('penerimaanServis', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Penerimaan Servis', url('service/penerimaanServis'));
});
// Home > pengembalianServis
Breadcrumbs::for('pengembalianServis', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Pengembalian Servis', url('service/pengembalianServis'));
});
// Home > kendaraanServis
Breadcrumbs::for('kendaraanServis', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Kendaraan Servis', url('service/kendaraanServis'));
});
// Home > roles
Breadcrumbs::for('roles', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Roles', url('setting/roles'));
});

// Home > kategoriPembayaran
Breadcrumbs::for('kategoriPembayaran', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Kategori Pembayaran', url('master/kategoriPembayaran'));
});

// Home > subPembayaran
Breadcrumbs::for('subPembayaran', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Sub Pembayaran', url('master/subPembayaran'));
});

// Home > penjualanCicilan
Breadcrumbs::for('penjualanCicilan', function (BreadcrumbTrail $trail) {
    $trail->parent('belumLunas');
    $trail->push('Penjualan Cicilan', url('purchase/penjualanCicilan?penjualan_id=' . request()->query('penjualan_id')));
});
