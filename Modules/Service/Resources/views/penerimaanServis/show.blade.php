<div>
    <div class="modal-body">
        @include('service::penerimaanServis.partials.detailServis')

        @if ($row->isdp_pservis)
            @include('service::penerimaanServis.partials.pembayaranServis')
        @endif

    </div>
    <div class="modal-footer">
        <div class="row justify-content-end">
            <div class="col-sm-12">
                <x-button-ok-modal />
            </div>
        </div>
    </div>
</div>
