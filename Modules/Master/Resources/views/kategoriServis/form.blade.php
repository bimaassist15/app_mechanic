<div>
    <form action="{{ $action }}" id="form-submit">
        <div class="modal-body">
            <x-form-input-horizontal label="Kategori Service" name="nama_kservis" placeholder="Kategori Service..."
                value="{{ isset($row) ? $row->nama_kservis ?? '' : '' }}" />
            <x-form-checkbox-horizontal label="Status Aktif" name="status_kservis" labelInput="Aktif"
                checked="{{ isset($row) ? ($row->status_kservis == true ? 'checked' : '') : 'checked' }}" />
        </div>
        <div class="modal-footer">
            <div class="row justify-content-end">
                <div class="col-sm-12">
                    <x-button-cancel-modal />
                    <x-button-submit-modal />
                </div>
            </div>
        </div>
    </form>
</div>
<script src="{{ asset('js/master/kategoriServis/form.js') }}"></script>
