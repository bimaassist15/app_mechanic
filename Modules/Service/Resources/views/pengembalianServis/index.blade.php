@extends('layouts.app.index')

@section('title')
    Halaman Pengembalian Servis
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('pengembalianServis') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data Pengembalian Servis
                    </div>
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nota</th>
                            <th>No. Antrian</th>
                            <th>Customer</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Biaya Servis</th>
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
        <script class="url_datatable" data-url="{{ url('service/pengembalianServis') }}"></script>
        <script class="url_root" data-url="{{ url('/') }}"></script>
        <script class="public_path" data-value="{{ asset('/') }}"></script>
        <script src="{{ asset('js/service/pengembalianServis/index.js') }}"></script>
    @endpush
@endsection
