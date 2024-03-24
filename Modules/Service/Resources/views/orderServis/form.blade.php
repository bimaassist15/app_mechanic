<div>
    <form method="post" action="{{ $action }}" id="form-submit">
        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12">
                    <x-form-select-vertical label="Mekanik" name="users_id_mekanik" :data="$array_users_mekanik"
                        value="{{ isset($row) ? $row->users_id_mekanik ?? '' : '' }}" />
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


<script src="{{ asset('js/service/orderServis/form.js') }}"></script>
