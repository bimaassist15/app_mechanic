<div>
    <form action="{{ $action }}" id="form-submit">
        <div class="modal-body">
            <x-form-input-horizontal label="Kategori Pembayaran" name="nama_kpembayaran"
                placeholder="Kategori Pembayaran..." value="{{ isset($row) ? $row->nama_kpembayaran ?? '' : '' }}" />
            <x-form-select-horizontal label="Tipe Pembayaran" name="tipe_kpembayaran" :data="$array_tipe_pembayaran"
                value="{{ isset($row) ? $row->tipe_kpembayaran ?? '' : '' }}" />
            <x-form-checkbox-horizontal label="Status Aktif" name="status_kpembayaran" labelInput="Aktif"
                checked="{{ isset($row) ? ($row->status_kpembayaran == true ? 'checked' : '') : 'checked' }}" />
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
<script src="{{ asset('js/master/kategoriPembayaran/form.js') }}"></script>
