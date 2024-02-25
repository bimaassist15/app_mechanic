<div>
    <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Tipe" name="nama" placeholder="Nama supplier..." />
                    <x-form-input-horizontal label="No. Whatsapp" name="no_wa" placeholder="Nomor Whatsapp..." />
                    <x-form-textarea-horizontal label="Keterangan" name="alamat" placeholder="Alamat lengkap..." />
                </div>
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Nama Perusahaan Supplier" name="perusahaan_supplier"
                        placeholder="Nama perusahaan supplier..." />
                    <x-form-checkbox-horizontal label="Status Aktif" name="status_supplier" labelInput="Aktif"
                        checked="checked" />
                </div>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <div class="row justify-content-end">
            <div class="col-sm-12">
                <x-button-cancel-modal />
                <x-button-submit-modal />
            </div>
        </div>
    </div>
</div>
