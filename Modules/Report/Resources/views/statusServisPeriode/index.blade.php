@extends('layouts.app.index')

@section('title')
    Halaman Servis Status Periode
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('reportStatusServisPeriode') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="w-50">
                        Data Servis Status Periode
                    </div>
                </div>
            </h5>
            <div class="card-body">
                @include('report::statusServisPeriode.partials.filter')

                @include('report::headerLaporan.index', [
                    'title' => 'Servis Status Per Periode',
                ])

                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="10%;">No.</th>
                                <th>Status Servis</th>
                                <th>Transaksi</th>
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
    <script src="{{ asset('js/report/statusServisPeriode/index.js') }}"></script>
@endpush
