<div>
    <form action="{{ $action }}" id="form-submit">
        <div class="modal-body">
            <x-form-input-horizontal label="Sub Pembayaran" name="nama_spembayaran" placeholder="Sub pembayaran..."
                value="{{ isset($row) ? $row->nama_spembayaran ?? '' : '' }}" />

            <x-form-select-horizontal label="Kategori Pembayaran" name="kategori_pembayaran_id" :data="$array_kategori_pembayaran"
                value="{{ isset($row) ? $row->kategori_pembayaran_id ?? '' : '' }}" />

            <x-form-checkbox-horizontal label="Status Aktif" name="status_spembayaran" labelInput="Aktif"
                checked="{{ isset($row) ? ($row->status_spembayaran == true ? 'checked' : '') : 'checked' }}" />
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
<script src="{{ asset('js/master/subPembayaran/form.js') }}"></script>
