<div style="height: 500px; overflow-y: scroll;">
    <form action="{{ $action }}" method="post">
        @include('service::penerimaanServis.partials.pengisianAwal')

        @include('service::penerimaanServis.partials.metodePembayaran')
    </form>
</div>


<script class="json_kategori_pembayaran" data-json="{{ $kategoriPembayaran }}"></script>
<script class="json_array_kategori_pembayaran" data-json="{{ $array_kategori_pembayaran }}"></script>
<script class="json_sub_pembayaran" data-json="{{ $subPembayaran }}"></script>
<script class="json_array_sub_pembayaran" data-json="{{ $array_sub_pembayaran }}"></script>
<script class="json_data_user" data-json="{{ $dataUser }}"></script>
<script class="json_default_user" data-json="{{ $defaultUser }}"></script>
<script class="json_cabang_id" data-json="{{ $cabangId }}"></script>
<script class="url_print_kasir" data-url="{{ route('pembelianCicilan.print') }}"></script>
<script class="url_simpan_kasir" data-url="{{ url('service/penerimaanServis') }}"></script>
<script class="isEdit" data-value="{{ $isEdit }}"></script>
<script class="url_transaction_kasir" data-url="{{ url('service/penerimaanServis/create') }}"></script>
<script class="totalHutang" data-value="{{ $totalHutang }}"></script>

<script src="{{ asset('js/service/penerimaanServis/form.js') }}"></script>
<script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free/assets/js/ui-popover.js') }}"></script>
