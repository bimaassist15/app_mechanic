<h5 class="card-header">
    <div class="row">
        <div class="col-lg-6">
            <h4 class="output_kodeTStock">Ref: {{ $kodeTStock }}</h4>
        </div>
        <div class="col-lg-6">
            <div style="width: 100%;">
                @php
                    $data = [['id' => '', 'label' => 'Belum Ada']];
                @endphp
                <x-form-select-vertical label="Barcode / Kode Barang" name="barang_id" :data="$data" />
            </div>

        </div>
    </div>
</h5>
