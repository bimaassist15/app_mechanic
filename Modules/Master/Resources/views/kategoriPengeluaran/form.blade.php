<div>
    <form action="{{ $action }}" id="form-submit">
        <div class="modal-body">
            <x-form-input-horizontal label="Kategori Pengeluaran" name="nama_kpengeluaran"
                placeholder="Kategori Pengeluaran..." value="{{ isset($row) ? $row->nama_kpengeluaran ?? '' : '' }}" />
            <x-form-checkbox-horizontal label="Status Aktif" name="status_kpengeluaran" labelInput="Aktif"
                checked="{{ isset($row) ? ($row->status_kpengeluaran == true ? 'checked' : '') : 'checked' }}" />
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
<script src="{{ asset('js/master/kategoriPengeluaran/form.js') }}"></script>
