@extends('layouts.app.index')

@section('title')
    Halaman Laporan Profit Pribadi
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('reportProfitPribadi') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data Laporan Profit Pribadi
                    </div>
                    <div>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                @include('report::profitPribadi.partials.filter')

                
                @include('report::headerLaporan.index', [
                    'title' => 'Teknisi'
                ])

                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="10%;">No.</th>
                                <th>Nota</th>
                                <th>Nama Servis</th>
                                <th>Teknisi</th>
                                <th>Total Biaya Jasa</th>
                                <th>Profit Toko</th>
                                <th>Pendapatan Teknisi</th>
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
    <script src="{{ asset('js/report/profitPribadi/index.js') }}"></script>
@endpush
