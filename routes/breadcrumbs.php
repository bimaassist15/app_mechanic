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

// Home > kasirPembelian
Breadcrumbs::for('kasirPembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('kasirPembelian', url('transaction/kasir'));
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
    $trail->push('Transfer Stok', url('transferStock/stock'));
});

// Home > stokkeluar
Breadcrumbs::for('stokkeluar', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Stok Keluar', url('transferStock/keluar'));
});
// Home > penerimaanServis
Breadcrumbs::for('penerimaanServis', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Penerimaan Servis', url('service/penerimaanServis'));
});

// Home > detailPenerimaanServis
Breadcrumbs::for('detailPenerimaanServis', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('penerimaanServis');
    $trail->push('Detail Penerimaan Servis', url('service/penerimaanServis/' . $id));
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

// Home > pembelianCicilan
Breadcrumbs::for('pembelianCicilan', function (BreadcrumbTrail $trail) {
    $trail->parent('belumLunasTransaction');
    $trail->push('Pembelian Cicilan', url('transaction/pembelianCicilan?pembelian_id=' . request()->query('pembelian_id')));
});

// Home > pengembalianServis
Breadcrumbs::for('pengembalianServis', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Pengembalian Servis', url('service/pengembalianServis'));
});

// Home > detailPengembalianServis
Breadcrumbs::for('detailPengembalianServis', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('pengembalianServis');
    $trail->push('Detail Pengembalian Servis', url('service/pengembalianServis/' . $id));
});

// Home > detailKendaraanServis
Breadcrumbs::for('detailKendaraanServis', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('kendaraanServis');
    $trail->push('Detail Kendaraan Servis', url('service/kendaraanServis/' . $id));
});

// Home > garansi
Breadcrumbs::for('garansi', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Garansi', url('service/garansi/'));
});

// Home > garansiDetail
Breadcrumbs::for('garansiDetail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('garansi');
    $trail->push('Detail Garansi', url('service/garansi/' . $id));
});

// Home > berkala
Breadcrumbs::for('berkala', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Berkala', url('service/berkala/'));
});

// Home > berkalaDetail
Breadcrumbs::for('berkalaDetail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('berkala');
    $trail->push('Detail berkala', url('service/berkala/' . $id));
});

// Home > mekanik
Breadcrumbs::for('mekanik', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Mekanik', url('service/mekanik/'));
});
// Home > mekanikDetail
Breadcrumbs::for('mekanikDetail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('mekanik');
    $trail->push('Detail Mekanik', url('service/mekanik/' . $id));
});

// Home > mekanikGaransi
Breadcrumbs::for('mekanikGaransi', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Mekanik Garansi', url('service/mekanikGaransi/'));
});
// Home > mekanikGaransiDetail
Breadcrumbs::for('mekanikGaransiDetail', function (BreadcrumbTrail $trail, $id) {
    $trail->parent('mekanikGaransi');
    $trail->push('Detail Mekanik Garansi', url('service/mekanikGaransi/' . $id));
});


// Home > kategoriPendapatan
Breadcrumbs::for('kategoriPendapatan', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Kategori Pendapatan', url('master/kategoriPendapatan/'));
});
// Home > kategoriPengeluaran
Breadcrumbs::for('kategoriPengeluaran', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Kategori Pengeluaran', url('master/kategoriPengeluaran/'));
});

// Home > pendapatan
Breadcrumbs::for('pendapatan', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Pendapatan', url('report/pendapatan/'));
});
// Home > pengeluaran
Breadcrumbs::for('pengeluaran', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Pendapatan', url('report/pengeluaran/'));
});
// Home > labaBersih
Breadcrumbs::for('labaBersih', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laba Bersih', url('report/labaBersih/'));
});
// Home > reportKasir
Breadcrumbs::for('reportKasir', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Kasir', url('report/kasir'));
});
// Home > reportCustomer
Breadcrumbs::for('reportCustomer', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Customer', url('report/customer'));
});
// Home > reportPeriode
Breadcrumbs::for('reportPeriode', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Periode', url('report/periode'));
});
// Home > reportProduk
Breadcrumbs::for('reportProduk', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Produk', url('report/produk'));
});
// Home > reportSupplier
Breadcrumbs::for('reportSupplier', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Supplier', url('report/supplier'));
});
// Home > reportPembelianProduk
Breadcrumbs::for('reportPembelianProduk', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Pembelian Produk', url('report/pembelianProduk'));
});
// Home > reportPeriodePembelian
Breadcrumbs::for('reportPeriodePembelian', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Periode Pembelian', url('report/periodePembelian'));
});
// Home > reportBarangTerlaris
Breadcrumbs::for('reportBarangTerlaris', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Barang Terlaris', url('report/barangTerlaris'));
});
// Home > reportStokTerkecil
Breadcrumbs::for('reportStokTerkecil', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Stok Terkecil', url('report/stokTerkecil'));
});
// Home > reportProfitPribadi
Breadcrumbs::for('reportProfitPribadi', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Profit Pribadi', url('report/profitPribadi'));
});
// Home > reportMekanik
Breadcrumbs::for('reportMekanik', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Mekanik', url('report/mekanik'));
});
// Home > reportServisPeriode
Breadcrumbs::for('reportServisPeriode', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Servis Per Periode', url('report/servisPeriode'));
});
// Home > reportStatusServis
Breadcrumbs::for('reportStatusServis', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Status Servis', url('report/statusServis'));
});
// Home > reportStatusServisPeriode
Breadcrumbs::for('reportStatusServisPeriode', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Laporan Status Servis Periode', url('report/statusServisPeriode'));
});

// Home > stokmasuk
Breadcrumbs::for('stokmasuk', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Stok Masuk', url('transferStock/masuk'));
});

// Home > estimasiServis
Breadcrumbs::for('estimasiServis', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Estimasi Servis', url('service/estimasiServis'));
});
