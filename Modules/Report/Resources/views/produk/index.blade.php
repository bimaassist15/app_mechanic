@extends('layouts.app.index')

@section('title')
    Halaman Laporan Produk
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('reportProduk') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data Laporan Produk
                    </div>
                    <div>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                @include('report::produk.partials.filter')

                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="10%;">No.</th>
                                <th>Tanggal</th>
                                <th>Barang</th>
                                <th>Terjual</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection

@push('custom_js')
    <script class="url_root" data-value="{{ url('/') }}"></script>
    <script src="{{ asset('js/report/produk/index.js') }}"></script>
@endpush
