@extends('layouts.app.index')

@section('title')
    Halaman Mekanik Garansi
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('mekanikGaransi') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    Data Mekanik Garansi
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
                            <th>Status</th>
                            <th>Tanggal Ambil</th>
                            <th>Masa Garansi</th>
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
        <script class="url_datatable" data-url="{{ url('service/mekanikGaransi') }}"></script>
        <script src="{{ asset('js/service/mekanikGaransi/index.js') }}"></script>
    @endpush
@endsection
