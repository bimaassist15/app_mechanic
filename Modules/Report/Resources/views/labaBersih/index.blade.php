@extends('layouts.app.index')

@section('title')
    Halaman Laba Bersih
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('labaBersih') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data Laba Bersih
                    </div>
                    <div>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                @include('report::labaBersih.partials.filter')
                <div id="output_result"></div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection

@push('custom_js')
    <script class="url_root" data-value="{{ url('/') }}"></script>
    <script src="{{ asset('js/report/labaBersih/index.js') }}"></script>
@endpush
