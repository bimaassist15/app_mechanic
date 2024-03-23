<div>
    <div class="modal-body">
        @include('master::customer.partials.biodata')

        @include('master::customer.partials.kendaraan')

        @include('master::customer.partials.history')

        @include('master::customer.partials.servis')


    </div>
    <div class="modal-footer">
        <div class="row justify-content-end">
            <div class="col-sm-12">
                <x-button-ok-modal />
            </div>
        </div>
    </div>
</div>

<script class="data_detail" data-value="{{ $row }}"></script>
<script class="data_payment" data-value="{{ $dataPayment }}"></script>
<script src="{{ asset('js/master/customer/detail.js') }}"></script>
