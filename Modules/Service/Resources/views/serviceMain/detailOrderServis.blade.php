@php
    $allowedSudahDiambil = ['sudah diambil', 'komplain garansi'];
@endphp
<div class="card mt-4">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="w-50">
                Biaya Jasa Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
            <div class="w-50">
                <x-form-select-vertical label="Cari Nama Servis" name="harga_servis_id" :data="$array_harga_servis" value=""
                    disabled="{{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}" />
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap px-3">
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kategori Servis</th>
                        <th>Nama Servis</th>
                        <th>Mekanik</th>
                        <th>Biaya</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody class="output_data_servis">
                    @include('service::penerimaanServis.output.servis')
                </tbody>
            </table>
        </div>
    </div>
</div>
