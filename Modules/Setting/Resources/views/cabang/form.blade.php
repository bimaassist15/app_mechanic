<div>
    <div class="modal-body">
        <form>
            <div class="card">
                <div class="card-header">
                    <strong>Data Bengkel</strong>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <x-form-input-horizontal label="Nama Bengkel" name="nama_bengkel"
                                placeholder="Nama Bengkel..." />
                            <x-form-input-horizontal label="Kota Bengkel" name="kota_bengkel"
                                placeholder="Kota Bengkel..." />
                            <x-form-textarea-horizontal label="Alamat" name="alamat" placeholder="Alamat..." />
                            <x-form-input-horizontal label="No. Telepon" name="no_telepon"
                                placeholder="Harga jual..." />
                            @php
                                $data = [['id' => '', 'label' => 'Belum Ada']];
                            @endphp
                            <x-form-select-horizontal label="Kategori" name="kategori_id" :data="$data" />

                        </div>
                        <div class="col-lg-6">
                            <x-form-input-horizontal label="Whatsapp" name="no_wa" placeholder="Nomor Whatsapp..." />
                            <x-form-input-horizontal label="Email" name="email" placeholder="Email..." />
                            <x-form-checkbox-horizontal label="Status Aktif" name="status_cabang" labelInput="Aktif"
                                checked="checked" />
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
                            <x-form-input-horizontal label="Tipe Print Toko" name="tipe_print"
                                placeholder="Tipe Print Toko..." />
                            <x-form-input-horizontal label="Ukuran Lebar Kertas (Thermal Cm)" name="width_paper"
                                placeholder="Ukuran lebar kertas..." />
                        </div>
                        <div class="col-lg-6">
                            @php
                                $data = [['id' => '', 'label' => 'Belum Ada']];
                            @endphp
                            <x-form-select-horizontal label="Tipe Print Service" name="tipe_print_servis"
                                :data="$data" />
                            <x-form-input-horizontal label="Ukuran Lebar Kertas (Thermal Cm)" name="width_paper_servis"
                                placeholder="Ukuran lebar kertas..." />
                            <x-form-input-horizontal label="Link Domain" name="link_domain"
                                placeholder="Link Domain..." />
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
                            <x-form-textarea-horizontal label="Teks Nota Servis Masuk" name="teks_nota_servis_masuk"
                                placeholder="Teks nota servis masuk..." />

                        </div>
                        <div class="col-lg-6">
                            <x-form-textarea-horizontal label="Teks Nota Servis Ambil" name="teks_nota_servis_ambil"
                                placeholder="Teks nota servis ambil..." />

                        </div>
                    </div>
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
