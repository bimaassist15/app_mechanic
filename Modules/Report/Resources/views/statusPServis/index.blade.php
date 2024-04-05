@extends('layouts.app.index')

@section('title')
    Halaman Servis Status
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('reportStatusServis') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div class="w-50">
                        Data Servis Status
                    </div>
                    <div class="w-50">
                        <div class="d-flex">
                            <div class="w-100">
                                <x-form-select-horizontal label="Pilih Status" name="status_pservis" :data="$status_pservis" />
                            </div>
                            <div>
                                <button type="button" class="btn btn-primary btn-filter me-2">
                                    <i class="fa-solid fa-filter me-2"></i> Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable" style="width: 100%;">
                        <thead>
                            <tr>
                                <th width="10%;">No.</th>
                                <th>Nota</th>
                                <th>Customer</th>
                                <th>Tanggal Masuk</th>
                                <th>Status</th>
                                <th>Mulai Servis</th>
                                <th>Lama Servis</th>
                                <th>Aksi</th>
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
    <script src="{{ asset('js/report/statusPServis/index.js') }}"></script>
@endpush
