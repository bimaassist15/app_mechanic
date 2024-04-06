<div class="row">
    <div class="col-lg-6">
        <div class="card bg-primary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-item-center">
                    <div>
                        <h3 class="text-white">Rp. {{ UtilsHelp::formatUang($total_penjualan) }}</h3>
                        <span class="text-white">Penjualan <strong>Hari Ini</strong> </span>
                    </div>
                    <div>
                        <i class="fa-solid fa-money-bill fa-4x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card bg-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-item-center">
                    <div>
                        <h3 class="text-white">Rp. {{ UtilsHelp::formatUang($total_penjualan_cash) }}</h3>
                        <span class="text-white">Invoice Penjualan Cash <strong>Hari Ini</strong> </span>
                    </div>
                    <div>
                        <i class="fa-solid fa-file-invoice fa-4x text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
