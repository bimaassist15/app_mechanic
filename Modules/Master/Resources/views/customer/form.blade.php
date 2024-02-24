<div>
    <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Nama Lengkap" name="nama_lengkap" placeholder="Nama Lengkap..." />
                    <x-form-input-horizontal type="number" label="Nomor Whatsapp" name="no_wa"
                        placeholder="Nomor Whatsapp..." />
                    <x-form-input-horizontal label="Email" name="email" placeholder="Email..." />
                </div>
                <div class="col-lg-6">
                    <x-form-textarea-horizontal label="Alamat" name="alamat" placeholder="Alamat lengkap..." />
                    <x-form-checkbox-horizontal label="Status" name="status" labelInput="Aktif" checked="checked" />
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
