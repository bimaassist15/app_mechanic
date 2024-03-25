@extends('layouts.app.index')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('transferStock') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                Pilih Lokasi Cabang
            </h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        @php
                            $data = [['id' => '', 'label' => 'Belum Ada']];
                        @endphp
                        <x-form-select-vertical label="Lokasi Cabang Awal" name="cabang_awal_id" :data="$data" />
                    </div>
                    <div class="col-lg-6">
                        @php
                            $data = [['id' => '', 'label' => 'Belum Ada']];
                        @endphp
                        <x-form-select-vertical label="Lokasi Cabang Penerima" name="cabang_penerima_id" :data="$data" />
                    </div>
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->


        <div class="card mt-2">
            <h5 class="card-header">
                <div class="row">
                    <div class="col-lg-6">
                        <h4>Ref: 83292898</h4>
                    </div>
                    <div class="col-lg-6">
                        <div class="d-flex">
                            <div style="width: 100%; margin-right: 10px;">
                                @php
                                    $data = [['id' => '', 'label' => 'Belum Ada']];
                                @endphp
                                <x-form-select-vertical label="Barcode / Kode Barang" name="kode_barang"
                                    :data="$data" />
                            </div>
                            <div style="padding-top: 30px;">
                                <x-button-main icon='<i class="fa-solid fa-magnifying-glass"></i>'></x-button-main>
                            </div>
                        </div>

                    </div>
                </div>
            </h5>
            <div class="card-body">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Qty</th>
                                <th>No. SN</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                        </tbody>
                    </table>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <x-form-textarea-vertical label="Catatan (Optional)" name="catatan"
                            placeholder="Tambahkan catatan secara detail" />
                    </div>
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <div class="d-flex mt-2 justify-content-end">
                            <x-button-main title="Transfer Sekarang" icon='<i class="fa-regular fa-paper-plane"></i>' />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ route('stock.index') }}"></script>
        <script src="{{ asset('js/transferStock/stock/index.js') }}"></script>
    @endpush
@endsection
