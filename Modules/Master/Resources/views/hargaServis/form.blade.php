<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Kode Servis" name="kode_hargaservis" placeholder="Kode Servis..."
                        value="{{ isset($row) ? $row->kode_hargaservis ?? '' : '' }}" />
                    <x-form-input-horizontal label="Nama Servis" name="nama_hargaservis" placeholder="Nama Servis..."
                        value="{{ isset($row) ? $row->nama_hargaservis ?? '' : '' }}" />
                    <x-form-textarea-horizontal label="Deskripsi" name="deskripsi_hargaservis"
                        placeholder="Deskripsi..." value="{{ isset($row) ? $row->deskripsi_hargaservis ?? '' : '' }}" />
                    <x-form-select-horizontal label="Kategori Servis" name="kategori_servis_id" :data="$array_kategori_servis"
                        value="{{ isset($row) ? $row->kategori_servis_id ?? '' : '' }}" />

                </div>
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Biaya Jasa Service Teknisi" name="jasa_hargaservis"
                        placeholder="Biaya Jasa Teknisi..."
                        value="{{ isset($row) ? $row->jasa_hargaservis ?? '' : '' }}" />
                    <x-form-input-horizontal label="Biaya Profit Bengkel" name="profit_hargaservis"
                        placeholder="Biaya Profit Bengkel..."
                        value="{{ isset($row) ? $row->profit_hargaservis ?? '' : '' }}" />
                    <x-form-checkbox-horizontal label="Status Aktif" name="status_hargaservis" labelInput="Aktif"
                        checked="{{ isset($row) ? ($row->status_hargaservis == true ? 'checked' : '') : 'checked' }}" />
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


<script src="{{ asset('js/master/hargaServis/form.js') }}"></script>
