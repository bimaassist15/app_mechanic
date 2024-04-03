@extends('layouts.app.index')

@section('title')
    Halaman Laporan Customer
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('reportCustomer') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data Laporan Customer
                    </div>
                    <div>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                @include('report::customer.partials.filter')

                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="10%;">No.</th>
                                <th>Nama</th>
                                <th>No. Whatsapp</th>
                                <th>Alamat</th>
                                <th>Saldo Customer</th>
                                <th>Transaksi Pembelian</th>
                                <th>Total Pembelian</th>
                                <th>Hutang Pembelian</th>
                                <th>Transaksi Servis</th>
                                <th>Total Servis</th>
                                <th>Hutang Servis</th>
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
    <script src="{{ asset('js/report/customer/index.js') }}"></script>
@endpush
