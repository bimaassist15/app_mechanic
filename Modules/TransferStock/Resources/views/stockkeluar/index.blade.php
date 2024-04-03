@extends('layouts.app.index')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('stokkeluar') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                Data Stok Keluar
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>No. Ref</th>
                            <th>Tanggal</th>
                            <th>Pengirim</th>
                            <th>Penerima</th>
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
        <script class="url_datatable" data-url="{{ url('transferstock/stokkeluar') }}"></script>

        <script src="{{ asset('js/master/stokkeluar/index.js') }}"></script>
    @endpush
@endsection
