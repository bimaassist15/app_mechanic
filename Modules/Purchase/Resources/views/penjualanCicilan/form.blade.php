<div class="card" style="height: 500px; overflow-y: scroll;">
    @include('purchase::penjualanCicilan.partials.headerCicilan', [
        'penjualan' => $penjualan,
    ])

    @include('purchase::penjualanCicilan.partials.metodePembayaran')
</div>

<script class="json_kategori_pembayaran" data-json="{{ $kategoriPembayaran }}"></script>
<script class="json_array_kategori_pembayaran" data-json="{{ $array_kategori_pembayaran }}"></script>
<script class="json_sub_pembayaran" data-json="{{ $subPembayaran }}"></script>
<script class="json_array_sub_pembayaran" data-json="{{ $array_sub_pembayaran }}"></script>
<script class="json_data_user" data-json="{{ $dataUser }}"></script>
<script class="json_default_user" data-json="{{ $defaultUser }}"></script>
<script class="json_cabang_id" data-json="{{ $cabangId }}"></script>
<script class="url_print_kasir" data-url="{{ url('purchase/penjualanCicilan/print/purchase') }}"></script>
<script class="url_simpan_kasir" data-url="{{ url('purchase/penjualanCicilan?penjualan_id=' . $penjualan_id) }}">
</script>
<script class="isEdit" data-value="{{ $isEdit }}"></script>
<script class="penjualan_id" data-value="{{ $penjualan_id }}"></script>
<script class="url_purchase_kasir"
    data-url="{{ url('purchase/penjualanCicilan/create?penjualan_id=' . $penjualan_id . '&isEdit=' . $isEdit) }}">
</script>
<script class="totalHutang" data-value="{{ $totalHutang }}"></script>
<script src="{{ asset('js/purchase/penjualanCicilan/form.js') }}"></script>
<script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free/assets/js/ui-popover.js') }}"></script>
