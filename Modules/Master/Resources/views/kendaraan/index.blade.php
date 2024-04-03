@extends('layouts.app.index')

@section('title')
    Halaman Kendaraan
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('kendaraan') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data kendaraan
                    </div>
                    <div>
                        <x-button-main title="Tambah" className="btn-add" typeModal="extraLargeModal"
                            urlCreate="{{ url('master/kendaraan/create') }}" />
                    </div>
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th>Nama</th>
                            <th>Tlpn/Wa</th>
                            <th>Merek</th>
                            <th>No. Pol</th>
                            <th>Jenis</th>
                            <th class="text-center">Aksi</th>
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
        <script class="url_datatable" data-url="{{ url('master/kendaraan') }}"></script>
        <script src="{{ asset('js/master/kendaraan/index.js') }}"></script>
    @endpush
@endsection
