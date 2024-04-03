@extends('layouts.app.index')

@section('title')
    Halaman Penjualan Cicilan
@endsection

@section('content')
    @php
        $getPenjualan = UtilsHelp::paymentStatisPenjualan($penjualan->id);
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between mb-3 align-items-center">
            {{ Breadcrumbs::render('penjualanCicilan') }}

            <div>
                @php
                    $disabled = $penjualan->hutang_penjualan == 0 ? true : false;
                    $title = $penjualan->hutang_penjualan == 0 ? 'Lunas' : 'Tambah';
                @endphp
                <x-button-main :title="$title" className="btn-add" typeModal="extraLargeModal"
                    urlCreate="{{ url('purchase/penjualanCicilan/create') }}" :disabled="$disabled" />
            </div>
        </div>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                @include('purchase::penjualanCicilan.partials.headerCicilan', [
                    'penjualan' => $penjualan,
                    'getPenjualan' => $getPenjualan,
                ])
            </h5>

            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th width="10%;">No.</th>
                            <th>Kategori Pembayaran</th>
                            <th>Sub Pembayaran</th>
                            <th>Bayar</th>
                            <th>Yang Menangani</th>
                            <th>Hutang</th>
                            <th>Kembalian</th>
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
        <script class="url_datatable" data-url="{{ url('purchase/penjualanCicilan?penjualan_id=' . $penjualan->id) }}"></script>
        <script class="penjualan_id" data-value="{{ $penjualan->id }}"></script>
        <script src="{{ asset('js/purchase/penjualanCicilan/index.js') }}"></script>
    @endpush
@endsection
