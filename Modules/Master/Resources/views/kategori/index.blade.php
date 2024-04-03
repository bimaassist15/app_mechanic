@extends('layouts.app.index')

@section('title')
    Kategori Page
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('kategori') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        Data Kategori
                    </div>
                    <div>
                        <x-button-main title="Tambah" className="btn-add" typeModal="mediumModal"
                            urlCreate="{{ url('master/kategori/create') }}" />
                    </div>
                </div>
            </h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th width="10%;">No.</th>
                                <th>Kategori</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Aksi</th>
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

    @push('custom_js')
        <script class="url_datatable" data-url="{{ url('master/kategori') }}"></script>
        <script src="{{ asset('js/master/kategori/index.js') }}"></script>
    @endpush
@endsection
