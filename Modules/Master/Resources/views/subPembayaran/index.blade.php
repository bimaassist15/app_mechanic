@extends('layouts.app.index')

@section('title')
    Halaman Sub Pembayaran
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('subPembayaran') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        Data Sub Pembayaran
                    </div>
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="me-2">
                            <x-form-select-vertical label="Kategori Pembayaran" name="kategori_pembayaran_id_filter"
                                :data="$array_kategori_pembayaran" value="" />
                        </div>
                        <div class="mt-2">
                            <x-button-main title="Tambah" className="btn-add" typeModal="mediumModal"
                                urlCreate="{{ url('master/subPembayaran/create') }}" />
                        </div>
                    </div>
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 10%;">No.</th>
                            <th>Sub pembayaran</th>
                            <th>Kategori Pembayaran</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ url('master/subPembayaran') }}"></script>
        <script src="{{ asset('js/master/subPembayaran/index.js') }}"></script>
    @endpush
@endsection
