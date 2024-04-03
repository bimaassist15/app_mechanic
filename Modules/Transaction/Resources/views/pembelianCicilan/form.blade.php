<div class="card" style="height: 500px; overflow-y: scroll;">
    @include('transaction::pembelianCicilan.partials.headerCicilan', [
        'pembelian' => $pembelian,
    ])

    @include('transaction::pembelianCicilan.partials.metodePembayaran')
</div>

<script class="json_kategori_pembayaran" data-json="{{ $kategoriPembayaran }}"></script>
<script class="json_array_kategori_pembayaran" data-json="{{ $array_kategori_pembayaran }}"></script>
<script class="json_sub_pembayaran" data-json="{{ $subPembayaran }}"></script>
<script class="json_array_sub_pembayaran" data-json="{{ $array_sub_pembayaran }}"></script>
<script class="json_data_user" data-json="{{ $dataUser }}"></script>
<script class="json_default_user" data-json="{{ $defaultUser }}"></script>
<script class="json_cabang_id" data-json="{{ $cabangId }}"></script>
<script class="url_print_kasir" data-url="{{ url('transaction/pembelianCicilan/print/transaction') }}"></script>
<script class="url_simpan_kasir" data-url="{{ url('transaction/pembelianCicilan?pembelian_id=' . $pembelian_id) }}">
</script>
<script class="isEdit" data-value="{{ $isEdit }}"></script>
<script class="pembelian_id" data-value="{{ $pembelian_id }}"></script>
<script class="url_transaction_kasir"
    data-url="{{ url('transaction/pembelianCicilan/create?pembelian_id=' . $pembelian_id . '&isEdit=' . $isEdit) }}">
</script>
<script class="totalHutang" data-value="{{ $totalHutang }}"></script>
<script src="{{ asset('js/transaction/pembelianCicilan/form.js') }}"></script>
<script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free/assets/js/ui-popover.js') }}"></script>
