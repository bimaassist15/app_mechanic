@extends('layouts.app.index')

@section('title')
    Halaman Berkala
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('berkala') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    Data Berkala
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nota</th>
                            <th>Customer</th>
                            <th>Tanggal Masuk</th>
                            <th>Tanggal Servis Berkala</th>
                            <th>Status</th>
                            <th>Sudah Info</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ url('service/berkala') }}"></script>
        <script class="url_root" data-value="{{ url('/') }}"></script>
        <script src="{{ asset('js/service/berkala/index.js') }}"></script>
    @endpush
@endsection
