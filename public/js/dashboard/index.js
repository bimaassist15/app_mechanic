var urlRoot = $(".url_root").data("value");
var body = $("body");
var datatable;

$(document).ready(function () {
    function initDatatableTerlaris() {
        datatable = basicDatatable({
            tableId: $("#tableBarangTerlaris"),
            ajaxUrl: `${urlRoot}/report/barangTerlaris`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "barcode_barang",
                    name: "barcode_barang",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "nama_barang",
                    name: "nama_barang",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "total_sum",
                    name: "total_sum",
                    searchable: false,
                    orderable: true,
                },
            ],
            dataAjaxUrl: {},
            tableInfo: "#tableBarangTerlaris",
        });
    }
    initDatatableTerlaris();

    function initDatatableTerkecil() {
        datatable = basicDatatable({
            tableId: $("#tableStokTerkcil"),
            ajaxUrl: `${urlRoot}/report/stokTerkecil`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "barcode_barang",
                    name: "barcode_barang",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "nama_barang",
                    name: "nama_barang",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "stok_barang",
                    name: "stok_barang",
                    searchable: false,
                    orderable: true,
                },
            ],
            dataAjaxUrl: {},
            tableInfo: "#tableStokTerkcil",
        });
    }
    initDatatableTerkecil();

    function initDatatableStatusServis() {
        datatable = basicDatatable({
            tableId: $("#tableStatusServis"),
            ajaxUrl: `${urlRoot}/report/statusServisPeriode`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "status_histori",
                    name: "status_histori",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "total_histori",
                    name: "total_histori",
                    searchable: true,
                    orderable: true,
                },
            ],
            dataAjaxUrl: {},
            tableInfo: "#tableStatusServis",
        });
    }
    initDatatableStatusServis();

    function initDatatablePiutangPenjualan() {
        datatable = basicDatatable({
            tableId: $("#tablePenjualan"),
            ajaxUrl: `${urlRoot}/dashboard/piutangPenjualan`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "invoice_penjualan",
                    name: "invoice_penjualan",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "transaksi_penjualan",
                    name: "transaksi_penjualan",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "customer.nama_customer",
                    name: "customer.nama_customer",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "jatuhtempo_penjualan",
                    name: "jatuhtempo_penjualan",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "total_penjualan",
                    name: "total_penjualan",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "action",
                    name: "action",
                    searchable: true,
                    orderable: true,
                },
            ],
            dataAjaxUrl: {},
            tableInfo: "#tablePenjualan",
        });
    }
    initDatatablePiutangPenjualan();

    body.on("click", ".btn-detail-penjualan", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Transaksi",
            type: "get",
        });
    });


    function initDatatablePiutangPembelian() {
        datatable = basicDatatable({
            tableId: $("#tablePembelian"),
            ajaxUrl: `${urlRoot}/dashboard/piutangPembelian`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "invoice_pembelian",
                    name: "invoice_pembelian",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "transaksi_pembelian",
                    name: "transaksi_pembelian",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "supplier.nama_supplier",
                    name: "supplier.nama_supplier",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "jatuhtempo_pembelian",
                    name: "jatuhtempo_pembelian",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "total_pembelian",
                    name: "total_pembelian",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "action",
                    name: "action",
                    searchable: true,
                    orderable: true,
                },
            ],
            dataAjaxUrl: {},
            tableInfo: "#tablePembelian",
        });
    }
    initDatatablePiutangPembelian();

    body.on("click", ".btn-detail-pembelian", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Transaksi",
            type: "get",
        });
    });
});
