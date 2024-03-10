@extends('layouts.app.index')

@section('title')
    Halaman Penjualan
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('barang') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            @include('purchase::kasir.partials.customer')

            @include('purchase::kasir.partials.invoice')

            @include('purchase::kasir.partials.metodePembayaran')
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ route('kasir.index') }}"></script>
        <script class="json_customer" data-json="{{ $dataCustomer }}"></script>
        <script class="json_barang" data-json="{{ $dataBarang }}"></script>
        <script class="json_tipe_diskon" data-json="{{ $dataTipeDiskon }}"></script>
        <script class="json_kategori_pembayaran" data-json="{{ $kategoriPembayaran }}"></script>
        <script class="json_array_kategori_pembayaran" data-json="{{ $array_kategori_pembayaran }}"></script>
        <script class="json_sub_pembayaran" data-json="{{ $subPembayaran }}"></script>
        <script class="json_array_sub_pembayaran" data-json="{{ $array_sub_pembayaran }}"></script>
        <script class="json_data_user" data-json="{{ $dataUser }}"></script>
        <script class="json_default_user" data-json="{{ $defaultUser }}"></script>
        <script src="{{ asset('js/purchase/kasir/index.js') }}"></script>
    @endpush
@endsection
