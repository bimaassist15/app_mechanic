<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <x-form-input-horizontal label="Tanggal Jatuh Tempo" name="jatuhtempo_penjualan"
                placeholder="Tanggal Jatuh Tempo..." value="{{ isset($row) ? UtilsHelp::formatDateLaporan($row->jatuhtempo_penjualan) ?? '' : '' }}" />

            <x-form-textarea-horizontal label="Keterangan" name="keteranganjtempo_penjualan" placeholder="Keterangan..."
                value="{{ isset($row) ? $row->keteranganjtempo_penjualan ?? '' : '' }}" rows="5" />

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
<script src="{{ asset('js/purchase/belumLunas/jatuhTempo.js') }}"></script>
