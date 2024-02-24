<div>
    <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Kode Servis" name="kode_servis" placeholder="Kode Servis..." />
                    <x-form-input-horizontal label="Nama Servis" name="nama_servis" placeholder="Nama Servis..." />
                    <x-form-textarea-horizontal label="Deskripsi" name="deskripsi_servis" placeholder="Deskripsi..." />
                    @php
                        $data = [['id' => '', 'label' => 'Belum Ada']];
                    @endphp
                    <x-form-select-horizontal label="Kategori Servis" name="kategori_service_id" :data="$data" />

                </div>
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Biaya Jasa Service Teknisi" name="biaya_jasa_mechanic"
                        placeholder="Biaya Jasa Teknisi..." />
                    <x-form-input-horizontal label="Biaya Profit Bengkel" name="biaya_profit_bengkel"
                        placeholder="Biaya Profit Bengkel..." />
                    <x-form-checkbox-horizontal label="Status Aktif" name="status_Servis" labelInput="Aktif"
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


<script src="{{ asset('js/master/Servis/form.js') }}"></script>
