<div class="mt-3">
    <div class="card handle-metode-pembayaran">
        <div class="card-header bg-primary text-white p-3 mb-3">
            <strong>Metode Pembayaran</strong>
        </div>
        <div class="card-body">
            <div class="row mt-4">
                <div class="col-lg-6">
                    <x-form-select-vertical label="Metode Pembayaran" name="kategori_pembayaran_id" :data="json_decode($array_kategori_pembayaran)"
                        value=""
                        disabled="{{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}" />
                </div>
                <div class="col-lg-6">
                    <button type="button" class="btn btn-primary btn-add-pembayaran" style="margin-top: 30px;"
                        {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}>
                        <i class="fa-solid fa-plus me-1"></i> Tambah Pembayaran
                    </button>
                </div>
            </div>
            <hr style="color: #1381f0;" />

            <div class="output_metode_pembayaran"></div>
        </div>
    </div>
</div>
