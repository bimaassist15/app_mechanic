<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">

            <x-form-input-horizontal label="Satuan" name="nama_satuan" placeholder="Nama satuan..."
                value="{{ isset($row) ? $row->nama_satuan ?? '' : '' }}" />
            <x-form-checkbox-horizontal label="Status Aktif" name="status_satuan" labelInput="Aktif"
                checked="{{ isset($row) ? ($row->status_satuan == true ? 'checked' : '') : 'checked' }}" />
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
<script src="{{ asset('js/master/satuan/form.js') }}"></script>
