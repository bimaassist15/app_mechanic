@extends('layouts.app.index')

@section('title')
    Detail Kendaraan Servis
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="areaPenerimaanServis">
            @include('service::kendaraanServis.partialsPenerimaan.detailInfoAwal')

            @include('service::kendaraanServis.partialsPenerimaan.detailCustomer')

            @include('service::kendaraanServis.partialsPenerimaan.detailOrderServis')

            @include('service::kendaraanServis.partialsPenerimaan.detailOrderBarang')

            @include('service::kendaraanServis.partialsPenerimaan.detailHistori')

            @include('service::kendaraanServis.partialsPenerimaan.detailInformasiServis')
        </div>

        <div class="areaPengembalianServis">
            @include('service::kendaraanServis.partialsPengembalian.detailInfoAwal')

            @include('service::kendaraanServis.partialsPengembalian.detailCustomer')

            @include('service::kendaraanServis.partialsPengembalian.detailOrderServis')

            @include('service::kendaraanServis.partialsPengembalian.detailOrderBarang')

            @include('service::kendaraanServis.partialsPengembalian.detailHistori')

            @include('service::kendaraanServis.partialsPengembalian.detailInformasiServis')
        </div>
    </div>
@endsection

@push('custom_js')
    <script class="penerimaanServisId" data-value="{{ $penerimaanServisId }}"></script>
    <script class="url_root" data-url="{{ url('/') }}"></script>
    <script>
        var urlRoot = $('.url_root').data('url');
        var jsonPenerimaanServisId = $('.penerimaanServisId').data('value');
        var getGlobalRefresh = false;

        const refreshDataGlobal = () => {
            $.ajax({
                url: `${urlRoot}/service/penerimaanServis/${jsonPenerimaanServisId}`,
                dataType: "json",
                type: "get",
                data: {
                    refresh: true,
                },
                async: false,
                success: function(data) {
                    const rowData = data.row;
                    const statusAllowed = ["bisa diambil"];
                    if (statusAllowed.includes(rowData.status_pservis)) {
                        getGlobalRefresh = true;
                    } else {
                        getGlobalRefresh = rowData.status_pservis;
                    }
                },
            });

            return getGlobalRefresh;
        };
    </script>
    <div class="areaPenerimaanServis">
        <script class="url_order_servis" data-url="{{ url('service/orderServis') }}"></script>
        <script class="url_get_order_servis" data-url="{{ url('service/orderServis') }}"></script>

        <script class="usersId" data-value="{{ $usersId }}"></script>
        <script class="getServis" data-value="{{ $getServis }}"></script>
        <script class="getBarang" data-value="{{ $barang }}"></script>
        <script class="getTipeDiskon" data-value="{{ $tipeDiskon }}"></script>
        <script class="cabangId" data-value="{{ $cabangId }}"></script>
        <script src="{{ asset('js/service/kendaraanServis/detail.js') }}"></script>
    </div>

    <div class="areaPengembalianServis">
        <script class="penerimaan_servis_id" data-value="{{ $row->id }}"></script>

        <script class="json_kategori_pembayaran" data-json="{{ $kategoriPembayaran }}"></script>
        <script class="json_array_kategori_pembayaran" data-json="{{ $array_kategori_pembayaran }}"></script>
        <script class="json_sub_pembayaran" data-json="{{ $subPembayaran }}"></script>
        <script class="json_array_sub_pembayaran" data-json="{{ $array_sub_pembayaran }}"></script>
        <script class="json_data_user" data-json="{{ $dataUser }}"></script>
        <script class="json_cabang_id" data-json="{{ $cabangId }}"></script>
        <script class="jsonRow" data-json="{{ $jsonRow }}"></script>

        <script class="getPembayaranServis" data-value="{{ $getPembayaranServis }}"></script>
        <script class="is_deposit" data-value="{{ $is_deposit }}"></script>
        <script class="totalHutang" data-value="{{ $totalHutang }}"></script>
        <script class="defaultUser" data-value="{{ $defaultUser }}"></script>
        <script src="{{ asset('js/service/kendaraanServis/detailPengembalian.js') }}"></script>
    </div>

    <script>
        refreshDataGlobal();
        const runGlobalRefresh = () => {
            if (getGlobalRefresh === true) {
                runDataPengembalian();
                $('.areaPenerimaanServis').hide();
                $('.areaPengembalianServis').show();
            } else {
                const statusCancel = ['tidak bisa', 'cancel'];
                if (!statusCancel.includes(getGlobalRefresh)) {
                    runDataPenerimaan();
                    $('.areaPenerimaanServis').show();
                    $('.areaPengembalianServis').hide();
                } else {
                    runDataPengembalian();
                    $('.areaPenerimaanServis').hide();
                    $('.areaPengembalianServis').show();
                }
            }
        };
        runGlobalRefresh();
    </script>
@endpush
