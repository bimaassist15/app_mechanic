<div>
    <form action="{{ $action }}" id="form-submit">
        <div class="modal-body">
            @props(['label', 'name', 'data', 'value' => ''])

            <x-form-select-horizontal label="Kategori Pengeluaran" name="kategori_pengeluaran_id" :data="$array_kategori_pengeluaran"
                value="{{ isset($row) ? $row->kategori_pengeluaran_id ?? '' : '' }}" />
            <x-form-input-horizontal label="Nominal" name="jumlah_tpengeluaran" placeholder="Nominal..."
                value="{{ isset($row) ? UtilsHelp::formatUang($row->jumlah_tpengeluaran) ?? '' : '' }}" />
            <x-form-input-horizontal label="Tanggal" name="tanggal_tpengeluaran" placeholder="Nominal..."
                value="{{ isset($row) ? UtilsHelp::formatDateLaporan($row->tanggal_tpengeluaran) ?? '' : date('d/m/Y') }}" />
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
<script src="{{ asset('js/report/pengeluaran/form.js') }}"></script>
