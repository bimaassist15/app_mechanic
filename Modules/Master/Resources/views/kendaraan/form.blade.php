<div>
    <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-lg-6">
                    @php
                        $data = [['id' => '', 'label' => 'Belum Ada']];
                    @endphp
                    <x-form-select-horizontal label="Nama Customer" name="customer_id" :data="$data" />
                    <x-form-input-horizontal label="Tipe" name="tipe_kendaraan" placeholder="Tipe kendaraan..." />
                    <x-form-input-horizontal label="Tahun rakit" name="tahun_rakit" placeholder="Tahun rakit..." />
                    <x-form-input-horizontal label="No. Rangka" name="no_rangka" placeholder="Nomor rangka..." />
                    <x-form-input-horizontal label="Merek" name="merek" placeholder="Merek..." />
                    <x-form-input-horizontal label="Tahun Buat" name="tahun_buat" placeholder="Tahun buat..." />
                </div>
                <div class="col-lg-6">
                    <x-form-input-horizontal label="No. Pol" name="no_pol" placeholder="Nomor Polisi..." />
                    <x-form-input-horizontal label="Jenis" name="jenis_kendaraan" placeholder="Jenis kendaraan..." />
                    <x-form-input-horizontal label="Silinder" name="silinder_kendaraan" placeholder="Silinder..." />
                    <x-form-input-horizontal label="No. Mesin" name="no_mesin" placeholder="Nomor mesin..." />
                    <x-form-input-horizontal label="Warna" name="warna" placeholder="Warna..." />
                    <x-form-textarea-horizontal label="Keterangan" name="keterangan_kendaraan"
                        placeholder="Keterangan..." />
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


