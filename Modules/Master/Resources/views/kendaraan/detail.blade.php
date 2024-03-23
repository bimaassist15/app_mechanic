<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <x-data-horizontal label="Nama Customer"
                        value="{{ isset($row) ? $row->customer->nama_customer ?? '' : '' }}" />
                    <x-data-horizontal label="Tipe Kendaraan"
                        value="{{ isset($row) ? $row->tipe_kendaraan ?? '' : '' }}" />
                    <x-data-horizontal label="Tahun Rakit"
                        value="{{ isset($row) ? $row->tahunrakit_kendaraan ?? '' : '' }}" />
                    <x-data-horizontal label="No. Rangka"
                        value="{{ isset($row) ? $row->norangka_kendaraan ?? '' : '' }}" />
                    <x-data-horizontal label="Merek" value="{{ isset($row) ? $row->merek_kendaraan ?? '' : '' }}" />
                    <x-data-horizontal label="Tahun Buat"
                        value="{{ isset($row) ? $row->tahunbuat_kendaraan ?? '' : '' }}" />
                </div>
                <div class="col-lg-6">
                    <x-data-horizontal label="No. Polisi"
                        value="{{ isset($row) ? $row->nopol_kendaraan ?? '' : '' }}" />
                    <x-data-horizontal label="Jenis Kendaraan"
                        value="{{ isset($row) ? $row->jenis_kendaraan ?? '' : '' }}" />
                    <x-data-horizontal label="Silinder"
                        value="{{ isset($row) ? $row->silinder_kendaraan ?? '' : '' }}" />
                    <x-data-horizontal label="No. Mesin"
                        value="{{ isset($row) ? $row->nomesin_kendaraan ?? '' : '' }}" />
                    <x-data-horizontal label="Warna" value="{{ isset($row) ? $row->warna_kendaraan ?? '' : '' }}" />
                    <x-data-horizontal label="Keterangan"
                        value="{{ isset($row) ? $row->keterangan_kendaraan ?? '' : '' }}" />
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row justify-content-end">
                <div class="col-sm-12">
                    <x-button-ok-modal />
                </div>
            </div>
        </div>
    </form>
</div>
<script src="{{ asset('js/master/kendaraan/form.js') }}"></script>
