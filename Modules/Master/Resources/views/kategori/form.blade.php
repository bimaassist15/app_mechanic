<div>
    <div class="modal-body">
        <form>
            <x-form-input-horizontal label="Kategori" name="nama_kategori" placeholder="Nama kategori..." />
            <x-form-checkbox-horizontal label="Status Aktif" name="status_kategori" labelInput="Aktif" checked="checked" />
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
