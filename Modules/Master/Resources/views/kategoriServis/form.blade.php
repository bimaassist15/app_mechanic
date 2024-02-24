<div>
    <div class="modal-body">
        <form>
            <x-form-input-horizontal label="Kategori Service" name="kategori_servis" placeholder="Kategori Service..." />
            <x-form-checkbox-horizontal label="Status Aktif" name="statuskategori_servis" labelInput="Aktif"
                checked="checked" />
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
