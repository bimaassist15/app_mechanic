@extends('layouts.app.index')

@section('title')
    Halaman Barang
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('barang') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data barang
                    </div>
                    <div>
                        <x-button-main title="Tambah" className="btn-add" typeModal="extraLargeModal"
                            urlCreate="{{ url('master/barang/create') }}" />
                    </div>
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Kode</th>
                            <th>Barang</th>
                            <th>Kategori</th>
                            <th>Harga jual</th>
                            <th>Stok</th>
                            <th>Status</th>
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
        <script class="url_datatable" data-url="{{ url('master/barang') }}"></script>

        <script src="{{ asset('js/master/barang/index.js') }}"></script>
    @endpush
@endsection
