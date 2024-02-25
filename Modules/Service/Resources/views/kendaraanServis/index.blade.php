@extends('layouts.app.index')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('kendaraanServis') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    Data Penerimaan Servis
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nota</th>
                            <th>No. Antrian</th>
                            <th>Customer</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Tanggal Ambil</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        <tr>
                            <th>1</th>
                            <td>7</td>
                            <td>2</td>
                            <td>Customer We</td>
                            <td>24 Februri 2024</td>
                            <td>Status</td>
                            <td>24 Februari 2024</td>
                            <td>
                                <x-button-main color="btn-primary" className="btn-detail"
                                    icon='<i class="fa-solid fa-circle-info"></i>' typeModal="extraLargeModal"
                                    urlCreate="{{ route('kendaraanServis.show', 1) }}" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ route('kendaraanServis.index') }}"></script>
        <script src="{{ asset('js/service/kendaraanServis/index.js') }}"></script>
    @endpush
@endsection
