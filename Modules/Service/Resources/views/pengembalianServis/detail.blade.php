@extends('layouts.app.index')

@section('title')
    Detail Pengembalian Servis
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('service::pengembalianServis.partials.detailInfoAwal')

        @include('service::pengembalianServis.partials.detailCustomer')

        @include('service::pengembalianServis.partials.detailOrderServis')

        @include('service::pengembalianServis.partials.detailOrderBarang')

        @include('service::pengembalianServis.partials.detailHistori')

        @include('service::pengembalianServis.partials.detailInformasiServis')

    </div>
@endsection

@push('custom_js')
    <script class="url_root" data-url="{{ url('/') }}"></script>
    <script class="penerimaan_servis_id" data-value="{{ $row->id }}"></script>

    {{-- pembayaran --}}
    <script class="json_kategori_pembayaran" data-json="{{ $kategoriPembayaran }}"></script>
    <script class="json_array_kategori_pembayaran" data-json="{{ $array_kategori_pembayaran }}"></script>
    <script class="json_sub_pembayaran" data-json="{{ $subPembayaran }}"></script>
    <script class="json_array_sub_pembayaran" data-json="{{ $array_sub_pembayaran }}"></script>
    <script class="json_data_user" data-json="{{ $dataUser }}"></script>
    <script class="json_default_user" data-json="{{ $defaultUser }}"></script>
    <script class="json_cabang_id" data-json="{{ $cabangId }}"></script>
    <script class="totalHutang" data-value="{{ $totalHutang }}"></script>
    {{-- end pembayaran --}}
    <script src="{{ asset('js/service/pengembalianServis/detail.js') }}"></script>
@endpush
