<div>
    <form action="{{ $action }}" id="form-submit">
        <div class="modal-body">
            @props(['label', 'name', 'data', 'value' => ''])

            <x-form-select-horizontal label="Kategori Pendapatan" name="kategori_pendapatan_id" :data="$array_kategori_pendapatan"
                value="{{ isset($row) ? $row->kategori_pendapatan_id ?? '' : '' }}" />

            {{-- <x-form-input-horizontal label="Kategori Pendapatan" name="nama_kpendapatan"
                placeholder="Kategori Pendapatan..." value="{{ isset($row) ? $row->nama_kpendapatan ?? '' : '' }}" />
            <x-form-checkbox-horizontal label="Status Aktif" name="status_kpendapatan" labelInput="Aktif"
                checked="{{ isset($row) ? ($row->status_kpendapatan == true ? 'checked' : '') : 'checked' }}" /> --}}
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
<script src="{{ asset('js/master/kategoriPendapatan/form.js') }}"></script>
