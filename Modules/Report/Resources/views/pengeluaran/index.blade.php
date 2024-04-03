@extends('layouts.app.index')

@section('title')
    Halaman Pengeluaran
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('pengeluaran') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data Pengeluaran
                    </div>
                    <div>
                        <x-button-main title="Tambah" className="btn-add" typeModal="mediumModal"
                            urlCreate="{{ url('report/pengeluaran/create') }}" />
                    </div>
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 10%;">No.</th>
                            <th>Kategori</th>
                            <th>Nominal</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ url('report/pengeluaran') }}"></script>
        <script src="{{ asset('js/report/pengeluaran/index.js') }}"></script>
    @endpush
@endsection
