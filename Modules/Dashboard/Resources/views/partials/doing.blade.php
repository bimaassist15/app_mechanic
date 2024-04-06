<div class="row mt-3">
    <div class="row">
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-item-center">
                        <div>
                            <i class="fa-solid fa-users fa-2x text-info"></i>
                        </div>
                        <div>
                            <span class="text-dark" style="font-size: 14px;">Servis Masuk <strong>Hari Ini</strong>
                            </span> <br>
                            <strong class="text-dark"
                                style="font-size: 14px;">{{ UtilsHelp::formatUang($servis_masuk) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-item-center">
                        <div>
                            <i class="fa-solid fa-wrench fa-2x text-primary"></i>
                        </div>
                        <div>
                            <span class="text-dark" style="font-size: 14px;"><strong>Proses Pengerjaan</strong>
                            </span> <br>
                            <strong class="text-dark" style="font-size: 14px;">{{ UtilsHelp::formatUang($proses_servis) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-item-center">
                        <div>
                            <i class="fa-brands fa-get-pocket fa-2x text-secondary"></i>
                        </div>
                        <div>
                            <span class="text-dark" style="font-size: 14px;"><strong>Servis Dapat Diambil</strong>
                            </span> <br>
                            <strong class="text-dark" style="font-size: 14px;">{{ UtilsHelp::formatUang($bisa_diambil) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-item-center">
                        <div>
                            <i class="fa-solid fa-flag-checkered fa-2x text-success"></i>
                        </div>
                        <div>
                            <span class="text-dark" style="font-size: 14px;"><strong>Servis Sudah Diambil</strong>
                            </span> <br>
                            <strong class="text-dark" style="font-size: 14px;">{{ UtilsHelp::formatUang($sudah_diambil) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
