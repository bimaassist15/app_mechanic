<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Kode Barang" name="barcode_barang" placeholder="Kode Barang..."
                        value="{{ isset($row) ? $row->barcode_barang ?? '' : '' }}" />
                    <x-form-input-horizontal label="Nama Barang" name="nama_barang" placeholder="Nama Barang..."
                        value="{{ isset($row) ? $row->nama_barang ?? '' : '' }}" />
                    <x-form-textarea-horizontal label="Deskripsi" name="deskripsi_barang" placeholder="Deskripsi..."
                        value="{{ isset($row) ? $row->deskripsi_barang ?? '' : '' }}" />
                    <x-form-input-horizontal label="Harga jual" name="hargajual_barang" placeholder="Harga jual..."
                        value="{{ isset($row) ? number_format($row->hargajual_barang, '0', '.', ',') ?? '' : '' }}" />

                    <x-form-select-horizontal label="Kategori" name="kategori_id" :data="$array_kategori"
                        value="{{ isset($row) ? $row->kategori_id ?? '' : '' }}" />

                </div>
                <div class="col-lg-6">
                    <x-form-select-horizontal label="Satuan" name="satuan_id" :data="$array_satuan"
                        value="{{ isset($row) ? $row->satuan_id ?? '' : '' }}" />
                    <x-form-select-horizontal label="Non-SN Or SN" name="snornonsn_barang" :data="$array_status_serial"
                        value="{{ isset($row) ? $row->snornonsn_barang ?? '' : '' }}" />
                    <x-form-input-horizontal label="Lokasi Rak" name="lokasi_barang" placeholder="Lokasi Barang..."
                        value="{{ isset($row) ? $row->lokasi_barang ?? '' : '' }}" />
                    <x-form-select-horizontal label="Status Barang" name="status_barang" :data="$array_status_barang"
                        value="{{ isset($row) ? $row->status_barang ?? '' : '' }}" />
                    <x-form-input-horizontal label="Stok Barang" name="stok_barang" placeholder="Stok Barang..."
                        value="{{ isset($row) ? $row->stok_barang ?? '' : '' }}" />
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


<script src="{{ asset('js/master/barang/form.js') }}"></script>
