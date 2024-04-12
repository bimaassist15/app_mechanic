@extends('layouts.app.index')

@section('title')
    Halaman Estimasi Servis
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('estimasiServis') }}

        @include('service::estimasiServis.partials.tabEstimasi')
        <br>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data Estimasi Servis
                    </div>
                    <div>
                        <x-button-main title="Tambah" className="btn-add" typeModal="extraLargeModal"
                            urlCreate="{{ url('service/penerimaanServis/create') }}" />
                    </div>
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Antrian</th>
                            <th>Customer</th>
                            <th>No. Pol</th>
                            <th>Kendaraan</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Estimasi Servis</th>
                            <th>Remember Estimasi</th>
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
        <script class="url_datatable" data-url="{{ url('service/estimasiServis') }}"></script>
        <script src="{{ asset('js/service/estimasiServis/index.js') }}"></script>
    @endpush
@endsection
