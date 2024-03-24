@extends('layouts.app.index')

@section('title')
    Detail Penerimaan Servis
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @include('service::penerimaanServis.partials.detailInfoAwal')

        @include('service::penerimaanServis.partials.detailCustomer')


        <div class="card mt-4">
            <div class="card-header">
                <div class="d-flex justify-content-between">
                    <div class="w-50">
                        Biaya Jasa Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                            {{ $row->nonota_pservis }}</strong>
                    </div>
                    <div class="w-50">
                        <x-form-select-vertical label="Cari Nama Servis" name="harga_servis_id" :data="$array_harga_servis"
                            value="" />
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Kategori Servis</th>
                                <th>Nama Servis</th>
                                <th>Mekanik</th>
                                <th>Biaya</th>
                                <th style="width: 15%;">Action</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0" id="onLoadServis">
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end">
                                    <strong>Total Biaya Jasa</strong>
                                </td>
                                <td>
                                    <span id="totalHargaServis"></span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Biaya Sparepart <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>No. SN</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>1</td>
                                <td>Motor</td>
                                <td>Servis Mesin</td>
                                <td>Afan T</td>
                                <td>3829238</td>
                                <td>Rp. 70.000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end">
                                    <strong>Total Biaya Sparepart</strong>
                                </td>
                                <td>Rp. 70.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                History Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <x-data-customer label="Tanggal Masuk" value="22 Februari 2024 10:00 Wib" />
                        <x-data-customer label="Status Servis (22 Februari 2024)" value="Sudah diambil" />
                        <x-data-customer label="Penerima / Pembuat Nota Penerimaan Servis" value="Ijat" />
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-8">
                        <strong>Detail History Servis</strong>
                        <table class="w-100 table">
                            <tr>
                                <td>1</td>
                                <td>22 Februari 2024 10:00 Wib</td>
                                <td>Bisa Diambil</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>22 Februari 2024 10:00 Wib</td>
                                <td>No. Antrian Masuk</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>22 Februari 2024 10:00 Wib</td>
                                <td>Cancel</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Komplain Garansi Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <x-data-customer label="Keluhan" value="Menyala Abangku" />
                        <x-data-customer label="Penerima Komplain" value="Bg Bim" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Informasi Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <x-data-customer label="Sub Total" value="Rp. 70.000" />
                        <x-data-customer label="Total Sisa Bayar" value="Rp. -30.000" />
                        <x-data-customer label="Catatan Teknisi" value="Tolong data lagi setiap 3 bulan sekali" />
                        <x-data-customer label="DP (Bayar Diawal)" value="Rp. 100.000" />
                        <x-data-customer label="Kondisi Barang Servis" value="Sudah bagus" />
                        <x-data-customer label="Status Servis" value="Sudah Diambil" />
                        <x-data-customer label="Servis Berkala" value="3 Bulan Sekali" />
                        <x-data-customer label="Servis Garansi" value="1 Bulan (24 Maret 2024)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom_js')
    <script class="url_order_servis" data-url="{{ url('service/orderServis') }}"></script>
    <script class="url_get_order_servis" data-url="{{ url('service/orderServis') }}"></script>
    <script class="url_root" data-url="{{ url('/') }}"></script>

    <script class="usersId" data-value="{{ $usersId }}"></script>
    <script class="penerimaanServisId" data-value="{{ $penerimaanServisId }}"></script>
    <script class="getServis" data-value="{{ $getServis }}"></script>
    <script src="{{ asset('js/service/penerimaanServis/detail.js') }}"></script>
@endpush
