<div>
    <div class="modal-body">
        @include('transferstock::stokMasuk.partials.headerTransfer')
        @include('transferstock::stokMasuk.partials.content')
    </div>
    <div class="modal-footer">
        <div class="row justify-content-end">
            <div class="col-sm-12">
                <x-button-ok-modal />
            </div>
        </div>
    </div>
</div>

<script class="url_root" data-value="{{ url('/') }}"></script>
<script class="id" data-value="{{ $row->id }}"></script>
<script src="{{ asset('js/transferStock/stokMasuk/detail.js') }}"></script>
