@php
    $allowedSudahDiambil = ['sudah diambil', 'komplain garansi'];
@endphp
<div class="card mt-4">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="w-50">
                Biaya Sparepart <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
            <div class="w-50">
                <x-form-select-vertical label="Cari Barang" name="barang_id" :data="$array_barang" value=""
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
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Diskon</th>
                        <th></th>
                        <th>Sub Total</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 output_order_barang" id="">
                    @include('service::penerimaanServis.output.orderBarang')
                </tbody>
            </table>
        </div>
    </div>
</div>
