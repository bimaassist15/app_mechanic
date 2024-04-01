<div>
    <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-lg-6">
                    @php
                        $data = [['id' => '', 'label' => 'Belum Ada']];
                    @endphp
                    <x-form-select-horizontal label="No. Polisi" name="no_polisi_id" :data="$data" />
                    <x-form-textarea-horizontal label="Keterangan" name="keterangan" placeholder="Keterangan..." />
                    @php
                        $data = [['id' => '', 'label' => 'Belum Ada']];
                    @endphp
                    <x-form-select-horizontal label="Tipe Servis" name="tipe_service_id" :data="$data" />
                    <x-form-input-horizontal label="Kerusakan" name="kerusakan" placeholder="Kerusakan..." />
                </div>
                <div class="col-lg-6">
                    @php
                        $data = [['id' => '', 'label' => 'Belum Ada']];
                    @endphp
                    <x-form-select-horizontal label="Kategori Servis" name="kategori_service_id" :data="$data" />
                    <x-form-input-horizontal label="Kondisi kendaraan masuk" name="kondisi_kendaraan_masuk"
                        placeholder="Kondisi kendaraan masuk..." />
                    <x-form-input-horizontal label="Uang Muka" name="dp" placeholder="Uang Muka..." />
                    <x-form-input-horizontal label="KM Sekarang" name="km_sekarang" placeholder="KM Sekarang..." />


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
