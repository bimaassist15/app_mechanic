@extends('layouts.app.index')

@section('title')
    Detail Pengambilan Servis
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('service::pengembalianServis.partials.detailInfoAwal')

        <div id="load_viewdata" class="text-center">
            <div>
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <strong>Loading...</strong>
        </div>
        <div id="output_data"></div>
    </div>
@endsection

@push('custom_js')
    <script class="url_root" data-url="{{ url('/') }}"></script>
    <script class="penerimaanServisId" data-value="{{ $penerimaanServisId }}"></script>
    <script src="{{ asset('js/service/main/index.js') }}"></script>
@endpush
