<div class="card mt-4">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="w-50">
                Biaya Jasa Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
            <div class="w-50">
                <x-form-select-vertical label="Cari Nama Servis" name="harga_servis_id" :data="$array_harga_servis" value="" />
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="output_data_servis">
            @include('service::penerimaanServis.output.servis')
        </div>
    </div>
</div>
