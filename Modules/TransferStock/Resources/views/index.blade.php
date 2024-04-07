@extends('layouts.app.index')

@section('title')
    Halaman Transfer Stock
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('transferStock') }}

        <!-- Basic Bootstrap Table -->
        @include('transferstock::partials.locate')
        <!--/ Basic Bootstrap Table -->


        <div class="card mt-2">
            @include('transferstock::partials.selectItem')

            <div class="card-body">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th style="width: 20%;">Qty</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0 loadOrderBarang">
                        </tbody>
                    </table>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <x-form-textarea-vertical label="Catatan (Optional)" name="keterangan_tstock"
                            placeholder="Tambahkan catatan secara detail" />
                    </div>
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <div class="d-flex mt-2 justify-content-end">
                            <x-button-main className="btn-submit" title="Transfer Sekarang"
                                icon='<i class="fa-regular fa-paper-plane"></i>' />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ url('transferstock/stock') }}"></script>
        <script class="url_root" data-value="{{ url('/') }}"></script>
        <script class="cabang_id" data-value="{{ $cabang_id }}"></script>
        <script class="users_id" data-value="{{ $users_id }}"></script>
        <script class="kode_tstock" data-value="{{ $kodeTStock }}"></script>
        <script class="barang" data-value="{{ $barang }}"></script>
        <script class="isEdit" data-value="{{ $isEdit }}"></script>
        <script class="id" data-value="{{ $id }}"></script>
        <script src="{{ asset('js/transferStock/stock/index.js') }}"></script>
    @endpush
@endsection
