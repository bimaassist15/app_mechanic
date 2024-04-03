@extends('layouts.app.index')

@section('title')
    Halaman User
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('user') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        Data User
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="me-2">
                            <x-form-select-vertical label="Cabang" name="cabang_id" :data="$array_cabang" value="" />
                        </div>
                        <div class="mt-4">
                            <x-button-main title="Tambah" className="btn-add" typeModal="extraLargeModal"
                                urlCreate="{{ url('setting/user/create') }}" />
                        </div>

                    </div>
                </div>
            </h5>
            <div class="card-body w-100">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>No. HP</th>
                                <th>Email</th>
                                <th>Level</th>
                                <th>Status</th>
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

    @push('custom_js')
        <script class="url_datatable" data-url="{{ url('setting/user') }}"></script>
        <script src="{{ asset('js/setting/user/index.js') }}"></script>
    @endpush
@endsection
