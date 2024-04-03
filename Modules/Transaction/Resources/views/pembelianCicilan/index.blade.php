@extends('layouts.app.index')

@section('title')
    Halaman Pembelian Cicilan
@endsection

@section('content')
    @php
        $getPembelian = UtilsHelp::paymentStatisPembelian($pembelian->id);
    @endphp
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="d-flex justify-content-between mb-3 align-items-center">
            {{ Breadcrumbs::render('pembelianCicilan') }}

            <div>
                @php
                    $disabled = $pembelian->hutang_pembelian == 0 ? true : false;
                    $title = $pembelian->hutang_pembelian == 0 ? 'Lunas' : 'Tambah';
                @endphp
                <x-button-main :title="$title" className="btn-add" typeModal="extraLargeModal"
                    urlCreate="{{ url('transaction/pembelianCicilan/create') }}" :disabled="$disabled" />
            </div>
        </div>

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                @include('transaction::pembelianCicilan.partials.headerCicilan', [
                    'pembelian' => $pembelian,
                    'getPembelian' => $getPembelian
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
        <script class="url_datatable" data-url="{{ url('transaction/pembelianCicilan?pembelian_id=' . $pembelian->id) }}">
        </script>
        <script class="pembelian_id" data-value="{{ $pembelian->id }}"></script>
        <script src="{{ asset('js/transaction/pembelianCicilan/index.js') }}"></script>
    @endpush
@endsection
