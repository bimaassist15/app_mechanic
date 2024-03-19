<div class="card">
    <div class="card-header bg-primary text-white p-3 mb-3 mt-3">
        <strong>Pengisian Awal</strong>
    </div>
    <div class="card-body mt-4">
        <div class="row">
            <div class="col-lg-6">
                <x-form-select-horizontal label="Kendaraan" name="kendaraan_id" :data="$array_kendaraan_servis"
                    value="{{ isset($row) ? $row->kendaraan_id ?? '' : '' }}" />
                <x-form-textarea-horizontal label="Keluhan" name="keluhan_pservis" placeholder="Keluhan..."
                    value="{{ isset($row) ? $row->keluhan_pservis ?? '' : '' }}" />
                <x-form-select-horizontal label="Tipe Servis" name="tipe_pservis" :data="$array_tipe_servis"
                    value="{{ isset($row) ? $row->tipe_pservis ?? '' : '' }}" />
                <x-form-input-horizontal label="Kerusakan" name="kerusakan_pservis" placeholder="Kerusakan..."
                    value="{{ isset($row) ? $row->kerusakan_pservis ?? '' : '' }}" />
            </div>
            <div class="col-lg-6">
                @php
                    $data = [['id' => '', 'label' => 'Belum Ada']];
                @endphp
                <x-form-select-horizontal label="Kategori Servis" name="kategori_servis_id" :data="$array_kategori_servis"
                    value="{{ isset($row) ? $row->kategori_servis_id ?? '' : '' }}" />

                <x-form-input-horizontal label="Kondisi kendaraan masuk" name="kondisi_pservis"
                    placeholder="Kondisi kendaraan masuk..."
                    value="{{ isset($row) ? $row->kondisi_pservis ?? '' : '' }}" />

                <x-form-checkbox-horizontal label="Deposit Pembayaran" name="isdp_pservis" labelInput="Aktif"
                    checked="{{ isset($row) ? ($row->isdp_pservis == true ? 'checked' : '') : 'checked' }}" />

                <x-form-input-horizontal label="KM Sekarang" name="kmsekarang_pservis" placeholder="KM Sekarang..."
                    value="{{ isset($row) ? $row->kmsekarang_pservis ?? '' : '' }}" />
            </div>
        </div>
    </div>
</div>
