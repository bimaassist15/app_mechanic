<div class="card">
    <h5 class="card-header">
        Pilih Lokasi Cabang
    </h5>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <x-form-select-vertical label="Lokasi Cabang Awal" name="cabang_id_awal" :data="$array_cabang" />
            </div>
            <div class="col-lg-6">
                @php
                    $data = [['id' => '', 'label' => 'Belum Ada']];
                @endphp
                <x-form-select-vertical label="Lokasi Cabang Penerima" name="cabang_id_penerima" :data="$array_cabang" />
            </div>
        </div>
    </div>
</div>
