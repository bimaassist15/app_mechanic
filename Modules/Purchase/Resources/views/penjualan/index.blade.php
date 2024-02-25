@extends('layouts.app.index')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('penjualan') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                Data Penjualan
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Invoice</th>
                            <th>Tanggal transaksi</th>
                            <th>Customer</th>
                            <th>Kasir</th>
                            <th>Sub total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <th>1</th>
                            <th>2389523723</th>
                            <th>24 Februari 2024</th>
                            <th>Bima</th>
                            <th>Bima</th>
                            <th>2.000.000</th>
                            <th>
                                <x-button-main color="btn-primary" className="btn-detail"
                                    icon='<i class="fa-solid fa-circle-info"></i>' typeModal="extraLargeModal"
                                    urlCreate="{{ route('penjualan.show', 1) }}" />
                            </th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ route('penjualan.index') }}"></script>
        <script src="{{ asset('js/purchase/penjualan/index.js') }}"></script>
    @endpush
@endsection
