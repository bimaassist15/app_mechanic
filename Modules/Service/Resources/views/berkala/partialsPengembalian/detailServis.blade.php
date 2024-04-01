<div class="card mb-3">
    <div class="card-header bg-primary text-white p-3 mb-3 mt-3">
        <strong>Detail Servis</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <x-data-customer label="Kendaraan" value="
                {{ $row->kendaraan->jenis_kendaraan }}" />

                <x-data-customer label="Keluhan" value="{{ $row->keluhan_pservis }}" />

                <x-data-customer label="Tipe Servis" value="{{ ucwords($row->tipe_pservis) }}" />

                <x-data-customer label="Kerusakan" value="{{ $row->kerusakan_pservis }}" />

            </div>
            <div class="col-lg-6">
                <x-data-customer label="Kategori Servis" value="{{ $row->kategoriServis->nama_kservis }}" />

                <x-data-customer label="Kondisi Masuk" value="{{ $row->kondisi_pservis }}" />

                @php
                    $getDeposit = $row->isdp_pservis
                        ? '<i class="fa-solid fa-check"></i>'
                        : '<i class="fa-solid fa-circle-xmark"></i>';
                @endphp
                <x-data-customer label="Deposit" value="{!! $getDeposit !!}" />

                <x-data-customer label="KM Sekarang" value="{{ $row->kmsekarang_pservis }}" />
            </div>
        </div>
    </div>
</div>
