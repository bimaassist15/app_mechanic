<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <div class="card">
                <div class="card-header">
                    <strong>Data Bengkel</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <x-form-input-horizontal label="Nama Bengkel" name="bengkel_cabang"
                                placeholder="Nama Bengkel..."
                                value="{{ isset($row) ? $row->bengkel_cabang ?? '' : '' }}" />

                            <x-form-input-horizontal label="Nama Cabang" name="nama_cabang" placeholder="Nama Cabang..."
                                value="{{ isset($row) ? $row->nama_cabang ?? '' : '' }}" />

                            <x-form-input-horizontal label="Kota Bengkel" name="kota_cabang"
                                placeholder="Kota Bengkel..."
                                value="{{ isset($row) ? $row->kota_cabang ?? '' : '' }}" />

                            <x-form-textarea-horizontal label="Alamat" name="alamat_cabang" placeholder="Alamat..."
                                value="{{ isset($row) ? $row->alamat_cabang ?? '' : '' }}" />

                            <x-form-input-horizontal label="No. Telepon" name="notelpon_cabang"
                                placeholder="No. Telpon..." value="{{ isset($row) ? $row->notelpon_cabang ?? '' : '' }}"
                                type="number" />

                        </div>
                        <div class="col-lg-6">
                            <x-form-input-horizontal label="Whatsapp" name="nowa_cabang" placeholder="Nomor Whatsapp..."
                                value="{{ isset($row) ? $row->nowa_cabang ?? '' : '' }}" type="number" />
                            <x-form-input-horizontal label="Email" name="email_cabang" placeholder="Email..."
                                value="{{ isset($row) ? $row->email_cabang ?? '' : '' }}" />
                            <x-form-checkbox-horizontal label="Status Aktif" name="status_cabang" labelInput="Aktif"
                                checked="{{ isset($row) ? ($row->status_cabang == true ? 'checked' : '') : 'checked' }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">
                    <strong>Data Printer</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <x-form-select-horizontal label="Tipe Print" name="tipeprint_cabang" :data="$array_tipe_print"
                                value="{{ isset($row) ? $row->tipeprint_cabang ?? '' : '' }}" />

                            <x-form-input-horizontal label="Ukuran Lebar Kertas (Thermal Cm)" name="lebarprint_cabang"
                                placeholder="Ukuran lebar kertas..."
                                value="{{ isset($row) ? $row->lebarprint_cabang ?? '' : '' }}" />
                        </div>
                        <div class="col-lg-6">
                            <x-form-select-horizontal label="Tipe Print Service" name="printservis_cabang"
                                :data="$array_tipe_print" value="{{ isset($row) ? $row->printservis_cabang ?? '' : '' }}" />
                            <x-form-input-horizontal label="Ukuran Lebar Kertas (Thermal Cm)"
                                name="lebarprintservis_cabang" placeholder="Ukuran lebar kertas..."
                                value="{{ isset($row) ? $row->lebarprintservis_cabang ?? '' : '' }}" />
                            <x-form-input-horizontal label="Link Domain" name="domain_cabang"
                                placeholder="Link Domain..."
                                value="{{ isset($row) ? $row->domain_cabang ?? '' : '' }}" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mt-3">
                <div class="card-header">
                    <strong>Tambahkan informasi Teks Nota Servis</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <x-form-textarea-horizontal label="Teks Nota Servis Masuk" name="teksnotamasuk_cabang"
                                placeholder="Teks nota servis masuk..."
                                value="{{ isset($row) ? $row->teksnotamasuk_cabang ?? '' : '' }}" />

                        </div>
                        <div class="col-lg-6">
                            <x-form-textarea-horizontal label="Teks Nota Servis Ambil" name="teksnotaambil_cabang"
                                placeholder="Teks nota servis ambil..."
                                value="{{ isset($row) ? $row->teksnotaambil_cabang ?? '' : '' }}" />

                        </div>
                    </div>
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


<script src="{{ asset('js/setting/cabang/form.js') }}"></script>
