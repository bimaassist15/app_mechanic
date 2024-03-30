@extends('layouts.app.index')

@section('title')
    Detail Garansi
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('service::garansi.partialsPengembalian.detailInfoAwal')

        @include('service::garansi.partialsPengembalian.detailCustomer')

        @include('service::garansi.partialsPengembalian.detailOrderServis')

        @include('service::garansi.partialsPengembalian.detailOrderBarang')

        @include('service::garansi.partialsPengembalian.detailHistori')

        @include('service::garansi.partialsPengembalian.detailInformasiServis')

        
    </div>
@endsection

@push('custom_js')
    <script class="penerimaanServisId" data-value="{{ $penerimaanServisId }}"></script>
    <script class="url_root" data-url="{{ url('/') }}"></script>
    <script class="penerimaan_servis_id" data-value="{{ $row->id }}"></script>
    <script class="json_kategori_pembayaran" data-json="{{ $kategoriPembayaran }}"></script>
    <script class="json_array_kategori_pembayaran" data-json="{{ $array_kategori_pembayaran }}"></script>
    <script class="json_sub_pembayaran" data-json="{{ $subPembayaran }}"></script>
    <script class="json_array_sub_pembayaran" data-json="{{ $array_sub_pembayaran }}"></script>
    <script class="json_data_user" data-json="{{ $dataUser }}"></script>
    <script class="json_cabang_id" data-json="{{ $cabangId }}"></script>
    <script class="jsonRow" data-json="{{ $jsonRow }}"></script>

    <script class="getPembayaranServis" data-value="{{ $getPembayaranServis }}"></script>
    <script class="is_deposit" data-value="{{ $is_deposit }}"></script>
    <script class="totalHutang" data-value="{{ $totalHutang }}"></script>
    <script class="defaultUser" data-value="{{ $defaultUser }}"></script>
    <script src="{{ asset('js/service/garansi/detail.js') }}"></script>
@endpush
