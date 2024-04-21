@extends('layouts.app.index')

@section('title')
    Detail Penerimaan Servis
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div id="output_data"></div>
        <div id="load_viewdata" class="text-center">
            <div>
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <strong>Loading...</strong>
        </div>
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
    <script class="cabangId" data-value="{{ $cabangId }}"></script>
    <script src="{{ asset('js/service/penerimaanServis/detail.js') }}"></script>
@endpush
