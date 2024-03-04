<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-6">
                    <x-form-input-horizontal label="Nama Lengkap" name="nama_customer" placeholder="Nama Lengkap..." value="{{ isset($row) ? $row->nama_customer ?? '' : '' }}" />
                    <x-form-input-horizontal type="number" label="Nomor Whatsapp" name="nowa_customer"
                        placeholder="Nomor Whatsapp..." value="{{ isset($row) ? $row->nowa_customer ?? '' : '' }}" />
                    <x-form-input-horizontal label="Email" name="email_customer" placeholder="Email..." value="{{ isset($row) ? $row->email_customer ?? '' : '' }}" />
                </div>
                <div class="col-lg-6">
                    <x-form-textarea-horizontal label="Alamat" name="alamat_customer" placeholder="Alamat lengkap..." value="{{ isset($row) ? $row->alamat_customer ?? '' : '' }}" />
                    <x-form-checkbox-horizontal label="Status" name="status_customer" labelInput="Aktif" checked="{{ isset($row) ? ($row->status_customer == true ? 'checked' : '') : 'checked' }}" />
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
<script src="{{ asset('js/master/customer/form.js') }}"></script>
