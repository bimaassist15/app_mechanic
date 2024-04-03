<div class="areaPenerimaanServis">
    <script class="url_root" data-url="{{ url('/') }}"></script>
    <script class="url_order_servis" data-url="{{ url('service/orderServis') }}"></script>
    <script class="url_get_order_servis" data-url="{{ url('service/orderServis') }}"></script>

    <script class="usersId" data-value="{{ $usersId }}"></script>
    <script class="getServis" data-value="{{ $getServis }}"></script>
    <script class="getBarang" data-value="{{ $barang }}"></script>
    <script class="getTipeDiskon" data-value="{{ $tipeDiskon }}"></script>
    <script class="cabangId" data-value="{{ $cabangId }}"></script>
    <script src="{{ asset('js/service/groupService/detail.js') }}"></script>
</div>
