<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <x-form-select-horizontal label="Nama Customer" name="customer_id" :data="$array_customer"
                        value="{{ isset($row) ? $row->customer_id ?? '' : '' }}" />
                    <x-form-input-horizontal label="Tipe" name="tipe_kendaraan" placeholder="Tipe kendaraan..."
                        value="{{ isset($row) ? $row->tipe_kendaraan ?? '' : '' }}" />
                    <x-form-input-horizontal label="Tahun rakit" name="tahunrakit_kendaraan"
                        placeholder="Tahun rakit..."
                        value="{{ isset($row) ? $row->tahunrakit_kendaraan ?? '' : '' }}" />
                    <x-form-input-horizontal label="No. Rangka" name="norangka_kendaraan" placeholder="Nomor rangka..."
                        value="{{ isset($row) ? $row->norangka_kendaraan ?? '' : '' }}" />
                    <x-form-input-horizontal label="Merek" name="merek_kendaraan" placeholder="Merek..."
                        value="{{ isset($row) ? $row->merek_kendaraan ?? '' : '' }}" />
                    <x-form-input-horizontal label="Tahun Buat" name="tahunbuat_kendaraan" placeholder="Tahun buat..."
                        value="{{ isset($row) ? $row->tahunbuat_kendaraan ?? '' : '' }}" />
                </div>
                <div class="col-lg-6">
                    <x-form-input-horizontal label="No. Pol" name="nopol_kendaraan" placeholder="Nomor Polisi..."
                        value="{{ isset($row) ? $row->nopol_kendaraan ?? '' : '' }}" />
                    <x-form-input-horizontal label="Jenis" name="jenis_kendaraan" placeholder="Jenis kendaraan..."
                        value="{{ isset($row) ? $row->jenis_kendaraan ?? '' : '' }}" />
                    <x-form-input-horizontal label="Silinder" name="silinder_kendaraan" placeholder="Silinder..."
                        value="{{ isset($row) ? $row->silinder_kendaraan ?? '' : '' }}" />
                    <x-form-input-horizontal label="No. Mesin" name="nomesin_kendaraan" placeholder="Nomor mesin..."
                        value="{{ isset($row) ? $row->nomesin_kendaraan ?? '' : '' }}" />
                    <x-form-input-horizontal label="Warna" name="warna_kendaraan" placeholder="Warna..."
                        value="{{ isset($row) ? $row->warna_kendaraan ?? '' : '' }}" />
                    <x-form-textarea-horizontal label="Keterangan" name="keterangan_kendaraan"
                        placeholder="Keterangan..."
                        value="{{ isset($row) ? $row->keterangan_kendaraan ?? '' : '' }}" />
                </div>
            </div>
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
<script src="{{ asset('js/master/kendaraan/form.js') }}"></script>
