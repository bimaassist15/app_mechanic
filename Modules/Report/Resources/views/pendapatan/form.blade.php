<div>
    <form action="{{ $action }}" id="form-submit">
        <div class="modal-body">
            @props(['label', 'name', 'data', 'value' => ''])

            <x-form-select-horizontal label="Kategori Pendapatan" name="kategori_pendapatan_id" :data="$array_kategori_pendapatan"
                value="{{ isset($row) ? $row->kategori_pendapatan_id ?? '' : '' }}" />
            <x-form-input-horizontal label="Nominal" name="jumlah_tpendapatan" placeholder="Nominal..."
                value="{{ isset($row) ? UtilsHelp::formatUang($row->jumlah_tpendapatan) ?? '' : '' }}" />
            <x-form-input-horizontal label="Tanggal" name="tanggal_tpendapatan" placeholder="Nominal..."
                value="{{ isset($row) ? UtilsHelp::formatDateLaporan($row->tanggal_tpendapatan) ?? '' : date('d/m/Y') }}" />
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
<script src="{{ asset('js/report/pendapatan/form.js') }}"></script>
