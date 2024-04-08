<div>
    <div class="modal-body">
        @include('service::penerimaanServis.partials.detailServis')

        @include('service::penerimaanServis.partials.pembayaranServis')


    </div>
    <div class="modal-footer">
        <div class="row justify-content-end">
            <div class="col-sm-12">
                <x-button-ok-modal />
            </div>
        </div>
    </div>
</div>
