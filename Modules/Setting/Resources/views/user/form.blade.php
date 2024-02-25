<div>
    <div class="modal-body">
        <form>
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Nama Lengkap" name="nama_lengkap" placeholder="Nama Lengkap..." />
                    <x-form-input-horizontal label="No. HP" name="no_hp" placeholder="Kota Bengkel..." />
                    <x-form-textarea-horizontal label="Alamat" name="alamat" placeholder="Alamat..." />
                </div>
                <div class="col-lg-6">
                    @php
                        $data = [['id' => '', 'label' => 'Belum Ada']];
                    @endphp
                    <x-form-select-horizontal label="Level" name="level" :data="$data" />
                    <x-form-input-horizontal label="Email" name="email" placeholder="Email..." />
                    <x-form-input-horizontal label="Password" name="password" placeholder="Password..." />
                    <x-form-checkbox-horizontal label="Status Aktif" name="status_cabang" labelInput="Aktif"
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


<script src="{{ asset('js/setting/cabang/form.js') }}"></script>
