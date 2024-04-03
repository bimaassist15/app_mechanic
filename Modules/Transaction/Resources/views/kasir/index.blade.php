@extends('layouts.app.index')

@section('title')
    Halaman Pembelian
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('kasirPembelian') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            @include('transaction::kasir.partials.supplier')

            @include('transaction::kasir.partials.invoice')

            @include('transaction::kasir.partials.metodePembayaran')
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>


    <div class="modal fade" id="modalConfirmBayar" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <span>Apakah anda yakin ingin, melakukan transaksi ini?</span>
                </div>
                <div class="modal-footer">
                    <div class="row w-100">
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-danger me-2 w-100" data-bs-dismiss="modal">
                                <i class="fa-regular fa-circle-xmark me-1"></i> Batal
                            </button>
                        </div>
                        <div class="col-lg-6">
                            <button type="button" class="btn btn-primary me-2 w-100 btn-confirm-bayar">
                                <i class="fa-solid fa-paper-plane me-2"></i> Bayar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @push('custom_js')
        <script class="url_root" data-url="{{ url('/') }}"></script>
        <script class="url_datatable" data-url="{{ url('transaction/kasir') }}"></script>
        <script class="json_supplier" data-json="{{ $dataSupplier }}"></script>
        <script class="json_barang" data-json="{{ $dataBarang }}"></script>
        <script class="json_tipe_diskon" data-json="{{ $dataTipeDiskon }}"></script>
        <script class="json_kategori_pembayaran" data-json="{{ $kategoriPembayaran }}"></script>
        <script class="json_array_kategori_pembayaran" data-json="{{ $array_kategori_pembayaran }}"></script>
        <script class="json_sub_pembayaran" data-json="{{ $subPembayaran }}"></script>
        <script class="json_array_sub_pembayaran" data-json="{{ $array_sub_pembayaran }}"></script>
        <script class="json_data_user" data-json="{{ $dataUser }}"></script>
        <script class="json_default_user" data-json="{{ $defaultUser }}"></script>
        <script class="json_cabang_id" data-json="{{ $cabangId }}"></script>
        <script class="json_no_invoice" data-json="{{ $noInvoice }}"></script>
        <script class="url_print_kasir" data-url="{{ url('transaction/pembelian/print/transaction') }}"></script>
        <script class="url_simpan_kasir" data-url="{{ url('transaction/kasir') }}"></script>
        <script class="url_invoice_pembelian" data-url="{{ url('transaction/pembelian') }}"></script>
        <script class="isEdit" data-value="{{ $isEdit }}"></script>
        <script class="pembelian_id" data-value="{{ $pembelian_id }}"></script>
        <script class="url_transaction_kasir"
            data-url="{{ $isEdit == 'true' ? url('transaction/kasir?pembelian_id=' . $pembelian_id . '&isEdit=' . $isEdit) : url('transaction/kasir') }}">
        </script>
        <script src="{{ asset('js/transaction/kasir/index.js') }}"></script>
    @endpush
@endsection
