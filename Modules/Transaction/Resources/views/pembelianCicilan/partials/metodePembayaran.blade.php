<div class="card-header bg-primary text-white p-3">
    <strong>Metode Pembayaran</strong>
</div>

<div class="card-body">
    <div class="row mt-4">
        <div class="col-lg-6">
            <x-form-select-vertical label="Metode Pembayaran" name="kategori_pembayaran_id" :data="json_decode($array_kategori_pembayaran)"
                value="" />
        </div>
        <div class="col-lg-6">
            <button type="button" class="btn btn-primary mt-4 btn-add-pembayaran">
                <i class="fa-solid fa-plus me-1"></i> Tambah Pembayaran
            </button>
        </div>
    </div>
    <hr style="color: #1381f0;" />

    <div class="output_metode_pembayaran"></div>

    <div class="row mt-3">
        <div class="col-lg-6"></div>
        <div class="col-lg-6">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary text-nowrap btn-bayar" data-bs-toggle="popover"
                    data-bs-offset="0,14" data-bs-placement="top" data-bs-html="true"
                    data-bs-content="
                    <p>Apakah anda yakin ingin menyelesaikan transaksi ini?</p> 
                    <div class='d-flex justify-content-between'>
                        <button type='button' class='btn btn-sm btn-outline-secondary popover close'>Batal</button>
                        <button type='button' class='btn btn-sm btn-primary btn-confirm-bayar'>Bayar</button></div>"
                    title="Pembayaran Kasir" id="btn-pop-over" disabled="disabled">
                    <i class="fa-solid fa-money-bill me-2"></i> Bayar
                </button>
            </div>


        </div>
    </div>
</div>
