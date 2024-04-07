<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">

            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-0"
                style="text-transform: capitalize; font-size: 22px;">Workshop
                App</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">
        <li class="menu-item {{ request()->is('dashboard') ? 'active' : '' }}">
            <a href="{{ url('dashboard') }}" class="menu-link">
                <i class="menu-icon tf-icons bx bx-home-circle"></i>
                <div data-i18n="Basic">Dashboard</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('myProfile') ? 'active' : '' }}">
            <a href="{{ url('myProfile') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-user-circle'></i>
                <div data-i18n="Basic">My Profile</div>
            </a>
        </li>

        @php
            $activeRoutesMaster = [
                'master/kategori',
                'master/satuan',
                'master/barang',
                'master/serialBarang',
                'master/generateBarcode',
                'master/customer',
                'master/kendaraan',
                'master/supplier',
                'master/kategoriServis',
                'master/hargaServis',
                'master/kategoriPembayaran',
                'master/subPembayaran',
            ];
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Transaksi Toko</span>
        </li>

        @php
            $activeRoutePurchase = ['purchase/kasir', 'purchase/penjualan', 'purchase/belumLunas', 'purchase/lunas'];
        @endphp
        <li
            class="menu-item {{ collect($activeRoutePurchase)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-money"></i>
                <div data-i18n="Penjualan">Penjualan</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('purchase/kasir') ? 'active' : '' }}">
                    <a href="{{ url('purchase/kasir') }}" class="menu-link">
                        <div data-i18n="Kasir">Kasir</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('purchase/penjualan') ? 'active' : '' }}">
                    <a href="{{ url('purchase/penjualan') }}" class="menu-link">
                        <div data-i18n="Invoice Penjualan">Invoice Penjualan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('purchase/belumLunas') ? 'active' : '' }}">
                    <a href="{{ url('purchase/belumLunas') }}" class="menu-link">
                        <div data-i18n="Belum Lunas">Invoice Hutang</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('purchase/lunas') ? 'active' : '' }}">
                    <a href="{{ url('purchase/lunas') }}" class="menu-link">
                        <div data-i18n="Invoice Lunas">Invoice Lunas</div>
                    </a>
                </li>
            </ul>
        </li>

        @php
            $activeRouteTransaction = [
                'transaction/kasir',
                'transaction/pembelian',
                'transaction/belumLunas',
                'transaction/lunas',
            ];
        @endphp
        <li
            class="menu-item {{ collect($activeRouteTransaction)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cart-alt"></i>
                <div data-i18n="Pembelian">Pembelian</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('transaction/kasir') ? 'active' : '' }}">
                    <a href="{{ url('transaction/kasir') }}" class="menu-link">
                        <div data-i18n="Pembelian">Pembelian</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('transaction/pembelian') ? 'active' : '' }}">
                    <a href="{{ url('transaction/pembelian') }}" class="menu-link">
                        <div data-i18n="Invoice Pembelian">Invoice Pembelian</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('transaction/belumLunas') ? 'active' : '' }}">
                    <a href="{{ url('transaction/belumLunas') }}" class="menu-link">
                        <div data-i18n="Belum Lunas">Invoice Hutang</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('transaction/lunas') ? 'active' : '' }}">
                    <a href="{{ url('transaction/lunas') }}" class="menu-link">
                        <div data-i18n="Invoice Lunas">Invoice Lunas</div>
                    </a>
                </li>
            </ul>
        </li>

        @php
            $activeRouteTransfer = ['transferStock/transaksi', 'transferStock/masuk', 'transferStock/keluar'];
        @endphp
        <li
            class="menu-item {{ collect($activeRouteTransfer)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class='menu-icon bx bx-repeat'></i>
                <div data-i18n="Transfer Stock">Transfer Stock</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('transferStock/transaksi') ? 'active' : '' }}">
                    <a href="{{ url('transferStock/transaksi') }}" class="menu-link">
                        <div data-i18n="Transaksi">Transaksi</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('transferStock/masuk') ? 'active' : '' }}">
                    <a href="{{ url('transferStock/masuk') }}" class="menu-link">
                        <div data-i18n="Masuk">Masuk</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('transferStock/keluar') ? 'active' : '' }}">
                    <a href="{{ url('transferStock/keluar') }}" class="menu-link">
                        <div data-i18n="Keluar">Keluar</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Servis</span>
        </li>
        @php
            $activeRouteService = ['service/penerimaanServis', 'service/pengembalianServis'];
        @endphp
        <li
            class="menu-item {{ collect($activeRouteService)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-wrench"></i>
                <div data-i18n="Transaksi Servis">Transaksi Servis</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('service/penerimaanServis') ? 'active' : '' }}">
                    <a href="{{ url('service/penerimaanServis') }}" class="menu-link">
                        <div data-i18n="Penerimaan">Penerimaan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('service/pengembalianServis') ? 'active' : '' }}">
                    <a href="{{ url('service/pengembalianServis') }}" class="menu-link">
                        <div data-i18n="Pengembalian">Pengembalian</div>
                    </a>
                </li>
            </ul>
        </li>

        @php
            $activeRouteService = [
                'service/kendaraanServis',
                'service/berkala',
                'service/garansi',
                'service/dikerjakan',
                'service/komplain',
            ];
        @endphp
        <li
            class="menu-item {{ collect($activeRouteService)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-list-ul"></i>
                <div data-i18n="Kendaraan Servis">Kendaraan Servis</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('service/kendaraanServis') ? 'active' : '' }}">
                    <a href="{{ url('service/kendaraanServis') }}" class="menu-link">
                        <div data-i18n="Kendaraan Servis">Kendaraan Servis</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('service/berkala') ? 'active' : '' }}">
                    <a href="{{ url('service/berkala') }}" class="menu-link">
                        <div data-i18n="Servis Berkala">Servis Berkala</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('service/garansi') ? 'active' : '' }}">
                    <a href="{{ url('service/garansi') }}" class="menu-link">
                        <div data-i18n="Servis Garansi">Servis Garansi</div>
                    </a>
                </li>
            </ul>
        </li>

        @php
            $activeRouteService = ['service/mekanik', 'service/mekanikGaransi'];
        @endphp
        <li
            class="menu-item {{ collect($activeRouteService)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-cog"></i>
                <div data-i18n="Mekanik">Mekanik</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('service/mekanik') ? 'active' : '' }}">
                    <a href="{{ url('service/mekanik') }}" class="menu-link">
                        <div data-i18n="Servis Dikerjakan">Servis Dikerjakan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('service/mekanikGaransi') ? 'active' : '' }}">
                    <a href="{{ url('service/mekanikGaransi') }}" class="menu-link">
                        <div data-i18n="Servis Mekanik Garansi">Servis Mekanik Garansi</div>
                    </a>
                </li>
            </ul>
        </li>

        @php
            $activeRoutesMaster = [
                'master/kategori',
                'master/satuan',
                'master/barang',
                'master/serialBarang',
                'master/generateBarcode',
                'master/customer',
                'master/kendaraan',
                'master/supplier',
                'master/kategoriServis',
                'master/hargaServis',
                'master/kategoriPembayaran',
                'master/subPembayaran',
                'master/kategoriPendapatan',
                'master/kategoriPengeluaran',
            ];
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Data Master</span>
        </li>
        <li
            class="menu-item {{ collect($activeRoutesMaster)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bx-dock-top"></i>
                <div data-i18n="Data Master">Data Master</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('master/kategori') ? 'active' : '' }}">
                    <a href="{{ url('master/kategori') }}" class="menu-link">
                        <div data-i18n="Kategori">Kategori</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/satuan') ? 'active' : '' }}">
                    <a href="{{ url('master/satuan') }}" class="menu-link">
                        <div data-i18n="Satuan">Satuan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/barang') ? 'active' : '' }}">
                    <a href="{{ url('master/barang') }}" class="menu-link">
                        <div data-i18n="Barang">Barang</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/customer') ? 'active' : '' }}">
                    <a href="{{ url('master/customer') }}" class="menu-link">
                        <div data-i18n="Customer">Customer</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/kendaraan') ? 'active' : '' }}">
                    <a href="{{ url('master/kendaraan') }}" class="menu-link">
                        <div data-i18n="Kendaraan">Kendaraan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/supplier') ? 'active' : '' }}">
                    <a href="{{ url('master/supplier') }}" class="menu-link">
                        <div data-i18n="Supplier">Supplier</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/kategoriServis') ? 'active' : '' }}">
                    <a href="{{ url('master/kategoriServis') }}" class="menu-link">
                        <div data-i18n="Kategori Servis">Kategori Servis</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/hargaServis') ? 'active' : '' }}">
                    <a href="{{ url('master/hargaServis') }}" class="menu-link">
                        <div data-i18n="Harga Servis">Harga Servis</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/kategoriPembayaran') ? 'active' : '' }}">
                    <a href="{{ url('master/kategoriPembayaran') }}" class="menu-link">
                        <div data-i18n="Kategori Pembayaran">Kategori Pembayaran</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/subPembayaran') ? 'active' : '' }}">
                    <a href="{{ url('master/subPembayaran') }}" class="menu-link">
                        <div data-i18n="Sub Pembayaran">Sub Pembayaran</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/kategoriPendapatan') ? 'active' : '' }}">
                    <a href="{{ url('master/kategoriPendapatan') }}" class="menu-link">
                        <div data-i18n="Kategori Pendapatan">Kategori Pendapatan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('master/kategoriPengeluaran') ? 'active' : '' }}">
                    <a href="{{ url('master/kategoriPengeluaran') }}" class="menu-link">
                        <div data-i18n="Kategori Pengeluaran">Kategori Pengeluaran</div>
                    </a>
                </li>
            </ul>
        </li>

        @php
            $activeRoutesLaporan = ['report/pendapatan', 'report/pengeluaran', 'report/labaBersih'];
        @endphp
        <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Laporan</span>
        </li>
        <li
            class="menu-item {{ collect($activeRoutesLaporan)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Laba Bersih">Laba Bersih</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('report/pendapatan') ? 'active' : '' }}">
                    <a href="{{ url('report/pendapatan') }}" class="menu-link">
                        <div data-i18n="Pendapatan">Pendapatan</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/pengeluaran') ? 'active' : '' }}">
                    <a href="{{ url('report/pengeluaran') }}" class="menu-link">
                        <div data-i18n="Pengeluaran">Pengeluaran</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/labaBersih') ? 'active' : '' }}">
                    <a href="{{ url('report/labaBersih') }}" class="menu-link">
                        <div data-i18n="Laba Bersih">Laba Bersih</div>
                    </a>
                </li>
            </ul>
        </li>
        @php
            $activeRoutesLaporanToko = [
                'report/kasir',
                'report/customer',
                'report/periode',
                'report/produk',
                'report/supplier',
                'report/pembelianProduk',
                'report/periodePembelian',
                'report/barangTerlaris',
                'report/stokTerkecil',
            ];
        @endphp
        <li
            class="menu-item {{ collect($activeRoutesLaporanToko)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Laporan Toko">Laporan Toko</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('report/kasir') ? 'active' : '' }}">
                    <a href="{{ url('report/kasir') }}" class="menu-link">
                        <div data-i18n="Kasir">Kasir</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/customer') ? 'active' : '' }}">
                    <a href="{{ url('report/customer') }}" class="menu-link">
                        <div data-i18n="Customer">Customer</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/periode') ? 'active' : '' }}">
                    <a href="{{ url('report/periode') }}" class="menu-link">
                        <div data-i18n="Periode">Periode</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/produk') ? 'active' : '' }}">
                    <a href="{{ url('report/produk') }}" class="menu-link">
                        <div data-i18n="Produk">Produk</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/supplier') ? 'active' : '' }}">
                    <a href="{{ url('report/supplier') }}" class="menu-link">
                        <div data-i18n="Supplier">Supplier</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/pembelianProduk') ? 'active' : '' }}">
                    <a href="{{ url('report/pembelianProduk') }}" class="menu-link">
                        <div data-i18n="Pembelian Produk">Pembelian Produk</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/periodePembelian') ? 'active' : '' }}">
                    <a href="{{ url('report/periodePembelian') }}" class="menu-link">
                        <div data-i18n="Periode Pembelian">Periode Pembelian</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/barangTerlaris') ? 'active' : '' }}">
                    <a href="{{ url('report/barangTerlaris') }}" class="menu-link">
                        <div data-i18n="B   arang Terlaris">Barang Terlaris</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/stokTerkecil') ? 'active' : '' }}">
                    <a href="{{ url('report/stokTerkecil') }}" class="menu-link">
                        <div data-i18n="Stok Terkecil">Stok Terkecil</div>
                    </a>
                </li>
            </ul>
        </li>
        @php
            $activeRoutesLaporanServis = [
                'report/profitPribadi',
                'report/mekanik',
                'report/servisPeriode',
                'report/statusServis',
                'report/statusServisPeriode',
            ];
        @endphp
        <li
            class="menu-item {{ collect($activeRoutesLaporanServis)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-report"></i>
                <div data-i18n="Laporan Servis">Laporan Servis</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('report/profitPribadi') ? 'active' : '' }}">
                    <a href="{{ url('report/profitPribadi') }}" class="menu-link">
                        <div data-i18n="Profit">Profit</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/mekanik') ? 'active' : '' }}">
                    <a href="{{ url('report/mekanik') }}" class="menu-link">
                        <div data-i18n="Mekanik">Mekanik</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/servisPeriode') ? 'active' : '' }}">
                    <a href="{{ url('report/servisPeriode') }}" class="menu-link">
                        <div data-i18n="Servis Periode">Profit Servis Periode</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/statusServis') ? 'active' : '' }}">
                    <a href="{{ url('report/statusServis') }}" class="menu-link">
                        <div data-i18n="Status Servis">Status Servis</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('report/statusServisPeriode') ? 'active' : '' }}">
                    <a href="{{ url('report/statusServisPeriode') }}" class="menu-link">
                        <div data-i18n="Status Servis">Status Periode</div>
                    </a>
                </li>
            </ul>
        </li>

        <li class="menu-header small text-uppercase"><span class="menu-header-text">Konfigurasi</span></li>
        <li class="menu-item {{ request()->is('setting/user') ? 'active' : '' }}">
            <a href="{{ url('setting/user') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-user-circle'></i>
                <div data-i18n="User">User</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('setting/roles') ? 'active' : '' }}">
            <a href="{{ url('setting/roles') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-user-account'></i>
                <div data-i18n="Role">Role</div>
            </a>
        </li>
        <li class="menu-item {{ request()->is('setting/cabang') ? 'active' : '' }}">
            <a href="{{ url('setting/cabang') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bxs-building-house'></i>
                <div data-i18n="Cabang">Cabang</div>
            </a>
        </li>
        @php
            $activeRoutesBackupRestore = ['setting/backup', 'setting/restore'];
        @endphp
        <li
            class="menu-item {{ collect($activeRoutesBackupRestore)->contains(function ($route) {
                return request()->is($route) || str_starts_with(request()->url(), url($route));
            })
                ? 'active'
                : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon tf-icons bx bxs-data"></i>
                <div data-i18n="Backup & Restore">Backup & Restore</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->is('setting/backup') ? 'active' : '' }}">
                    <a href="{{ url('setting/backup') }}" class="menu-link">
                        <div data-i18n="Backup">Backup</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->is('setting/restore') ? 'active' : '' }}">
                    <a href="{{ url('setting/restore') }}" class="menu-link">
                        <div data-i18n="Restore">Restore</div>
                    </a>
                </li>
            </ul>
        </li>
        <li class="menu-item {{ request()->is('setting/logout') ? 'active' : '' }}">
            <a href="{{ url('setting/logout') }}" class="menu-link">
                <i class='menu-icon tf-icons bx bx-log-out'></i>
                <div data-i18n="Logout">Logout</div>
            </a>
        </li>
    </ul>
</aside>
