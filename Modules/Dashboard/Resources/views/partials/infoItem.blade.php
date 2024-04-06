<div class="row mt-3">
    <div class="row">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-item-center">
                        <div>
                            <h3 class="text-dark">{{ UtilsHelp::formatUang($barang_terjual) }}</h3>
                            <span class="text-dark">Total <strong>Barang Terjual</strong> <i>Hari ini</i> </span>
                        </div>
                        <div>
                            <i class="fa-solid fa-cart-shopping fa-4x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-item-center">
                        <div>
                            <h3 class="text-dark">{{ UtilsHelp::formatUang($jumlah_barang) }}</h3>
                            <span class="text-dark"><strong>Jumlah Barang</strong> </span>
                        </div>
                        <div>
                            <i class="fa-solid fa-bag-shopping fa-4x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-item-center">
                        <div>
                            <h3 class="text-dark">{{ UtilsHelp::formatUang($invoice_penjualan) }}</h3>
                            <span class="text-dark">Total <strong>Invoice Penjualan</strong> </span>
                        </div>
                        <div>
                            <i class="fa-solid fa-table fa-4x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
