<div style="height: 500px; overflow-y: scroll;">
    <form action="{{ $action }}" method="post">
        @include('service::penerimaanServis.partials.pengisianAwal')

        @include('service::penerimaanServis.partials.metodePembayaran')

        <div class="row mt-3 me-3 mb-3" class="handle-metode-pembayaran">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">
                        <i class="fa-regular fa-circle-xmark me-1"></i> Cancel
                    </button>

                    <button type="button" class="btn btn-primary btn-bayar" data-bs-toggle="popover"
                        data-bs-offset="0,14" data-bs-placement="top" data-bs-html="true"
                        data-bs-content="
                    <p>Apakah anda yakin ingin menyelesaikan transaksi ini?</p> 
                    <div class='d-flex justify-content-between'>
                        <button type='button' class='btn btn-sm btn-outline-secondary popover close'>Batal</button>
                        <button type='button' class='btn btn-sm btn-primary btn-confirm-bayar'>Bayar</button></div>"
                        title="Pembayaran Kasir" id="btn-pop-over" disabled="disabled">
                        <i class="fa-regular fa-paper-plane me-1"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>


<script class="json_kategori_pembayaran" data-json="{{ $kategoriPembayaran }}"></script>
<script class="json_array_kategori_pembayaran" data-json="{{ $array_kategori_pembayaran }}"></script>
<script class="json_sub_pembayaran" data-json="{{ $subPembayaran }}"></script>
<script class="json_array_sub_pembayaran" data-json="{{ $array_sub_pembayaran }}"></script>
<script class="json_data_user" data-json="{{ $dataUser }}"></script>
<script class="json_default_user" data-json="{{ $defaultUser }}"></script>
<script class="json_cabang_id" data-json="{{ $cabangId }}"></script>
<script class="url_print_kasir" data-url="{{ url('transaction/pembelianCicilan/print/transaction') }}"></script>
<script class="url_simpan_kasir" data-url="{{ url('service/penerimaanServis') }}"></script>
<script class="isEdit" data-value="{{ $isEdit }}"></script>
<script class="url_transaction_kasir" data-url="{{ url('service/penerimaanServis/create') }}"></script>
<script class="totalHutang" data-value="{{ $totalHutang }}"></script>
<script class="data_kendaraan" data-value="{{ $kendaraanServis }}"></script>

<script src="{{ asset('js/service/penerimaanServis/form.js') }}"></script>
<script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free/assets/js/ui-popover.js') }}"></script>
