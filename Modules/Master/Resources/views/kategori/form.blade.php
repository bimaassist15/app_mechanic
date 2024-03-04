<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <x-form-input-horizontal label="Kategori" name="nama_kategori" placeholder="Nama kategori..."
                value="{{ isset($row) ? $row->nama_kategori ?? '' : '' }}" />
            <x-form-checkbox-horizontal label="Status Aktif" name="status_kategori" labelInput="Aktif"
                checked="{{ isset($row) ? ($row->status_kategori == true ? 'checked' : '') : 'checked' }}" />
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
<script src="{{ asset('js/master/kategori/form.js') }}"></script>
