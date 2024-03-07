<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Nama supplier" name="nama_supplier" placeholder="Nama supplier..."
                        value="{{ isset($row) ? $row->nama_supplier ?? '' : '' }}" />
                    <x-form-input-horizontal type="number" label="No. Whatsapp" name="nowa_supplier"
                        placeholder="Nomor Whatsapp..." value="{{ isset($row) ? $row->nowa_supplier ?? '' : '' }}" />
                    <x-form-textarea-horizontal label="Keterangan" name="deskripsi_supplier"
                        placeholder="Deskripsi Supplier..."
                        value="{{ isset($row) ? $row->deskripsi_supplier ?? '' : '' }}" />
                </div>
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Nama Perusahaan Supplier" name="perusahaan_supplier"
                        placeholder="Nama perusahaan supplier..."
                        value="{{ isset($row) ? $row->perusahaan_supplier ?? '' : '' }}" />
                    <x-form-checkbox-horizontal label="Status Aktif" name="status_supplier" labelInput="Aktif"
                        checked="{{ isset($row) ? ($row->status_supplier == true ? 'checked' : '') : 'checked' }}" />
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

<script src="{{ asset('js/master/supplier/form.js') }}"></script>
