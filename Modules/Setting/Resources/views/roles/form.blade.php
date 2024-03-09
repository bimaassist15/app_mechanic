<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            <x-form-input-horizontal label="Nama Role" name="name" placeholder="Nama Role..."
                value="{{ isset($row) ? $row->name ?? '' : '' }}" />
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
<script src="{{ asset('js/setting/roles/form.js') }}"></script>
