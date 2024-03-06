@extends('layouts.app.index')

@section('title')
    Halaman Serial Barang
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('serialBarang') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data Stok <strong class="text-primary">
                            {{ $barang->nama_barang }} = {{ $barang->stok_barang }}
                            Stok
                        </strong>
                    </div>
                    <div>
                        <x-button-main title="Tambah" className="btn-add" typeModal="mediumModal"
                            urlCreate="{{ url('master/serialBarang/create?barang_id=' . $barang->id) }}" />
                    </div>
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th class="text-left">No. SN</th>
                            <th>Status</th>
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
        <script class="url_datatable" data-url="{{ url('master/serialBarang?barang_id=' . $barang->id) }}"></script>
        <script src="{{ asset('js/master/serialBarang/index.js') }}"></script>
    @endpush
@endsection
