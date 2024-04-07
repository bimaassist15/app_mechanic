<div>
    <div class="modal-body">
        @include('transferstock::stokKeluar.partials.headerTransfer')
        @include('transferstock::stokKeluar.partials.content')
    </div>
    <div class="modal-footer">
        <div class="row justify-content-end">
            <div class="col-sm-12">
                <x-button-ok-modal />
            </div>
        </div>
    </div>
</div>
