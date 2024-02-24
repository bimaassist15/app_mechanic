<div>
    <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Kode Barang" name="kode_barang" placeholder="Kode Barang..." />
                    <x-form-input-horizontal label="Nama Barang" name="nama_barang" placeholder="Nama Barang..." />
                    <x-form-textarea-horizontal label="Deskripsi" name="deskripsi_barang" placeholder="Deskripsi..." />
                    <x-form-input-horizontal label="Harga jual" name="harga_jual" placeholder="Harga jual..." />
                    @php
                        $data = [['id' => '', 'label' => 'Belum Ada']];
                    @endphp
                    <x-form-select-horizontal label="Kategori" name="kategori_id" :data="$data" />

                </div>
                <div class="col-lg-6">
                    @php
                        $data = [['id' => '', 'label' => 'Belum Ada']];
                    @endphp
                    <x-form-select-horizontal label="Satuan" name="satuan_id" :data="$data" />
                    @php
                        $data = [['id' => '', 'label' => 'Belum Ada']];
                    @endphp
                    <x-form-select-horizontal label="Non-SN Or SN" name="nonsn_or_sn" :data="$data" />
                    <x-form-input-horizontal label="Stok" name="stok_barang" placeholder="Stok Barang..." />
                    <x-form-input-horizontal label="Lokasi Rak" name="lokasi_barang" placeholder="Lokasi Barang..." />
                    <x-form-checkbox-horizontal label="Status Aktif" name="status_barang" labelInput="Aktif"
                        checked="checked" />
                </div>
            </div>

        </form>
    </div>
    <div class="modal-footer">
        <div class="row justify-content-end">
            <div class="col-sm-12">
                <x-button-cancel-modal />
                <x-button-submit-modal />
            </div>
        </div>
    </div>
</div>


<script src="{{ asset('js/master/barang/form.js') }}"></script>
