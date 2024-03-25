@extends('layouts.app.index')

@section('title')
    Detail Penerimaan Servis
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('service::penerimaanServis.partials.detailInfoAwal')

        @include('service::penerimaanServis.partials.detailCustomer')

        @include('service::penerimaanServis.partials.detailOrderServis')

        @include('service::penerimaanServis.partials.detailOrderBarang')

        @include('service::penerimaanServis.partials.detailHistori')

        @include('service::penerimaanServis.partials.detailInformasiServis')

    </div>
@endsection

@push('custom_js')
    <script class="url_order_servis" data-url="{{ url('service/orderServis') }}"></script>
    <script class="url_get_order_servis" data-url="{{ url('service/orderServis') }}"></script>
    <script class="url_root" data-url="{{ url('/') }}"></script>

    <script class="usersId" data-value="{{ $usersId }}"></script>
    <script class="penerimaanServisId" data-value="{{ $penerimaanServisId }}"></script>
    <script class="getServis" data-value="{{ $getServis }}"></script>
    <script class="getBarang" data-value="{{ $barang }}"></script>
    <script class="getTipeDiskon" data-value="{{ $tipeDiskon }}"></script>
    <script class="cabangId" data-value="{{ $cabangId }}"></script>
    <script src="{{ asset('js/service/penerimaanServis/detail.js') }}"></script>
@endpush
