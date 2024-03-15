// "use strict";
var datatable;
var myModal;
var penjualanId = $(".penjualan_id").data("value");

$(document).ready(function () {
    function initDatatable() {
        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: $(".url_datatable").data("url"),
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "kategori_pembayaran.nama_kpembayaran",
                    name: "kategori_pembayaran.nama_kpembayaran",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "sub_pembayaran.nama_spembayaran",
                    name: "sub_pembayaran.nama_spembayaran",
                    orderable: false,
                    searchable: false,
                },
                {
                    data: "bayar_pcicilan",
                    name: "bayar_pcicilan",
                    searchable: true,
                },
                {
                    data: "users.profile.nama_profile",
                    name: "users.profile.nama_profile",
                    searchable: true,
                },
                {
                    data: "hutang_pcicilan",
                    name: "hutang_pcicilan",
                    searchable: true,
                },
                {
                    data: "kembalian_pcicilan",
                    name: "kembalian_pcicilan",
                    searchable: true,
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                    orderable: false,
                },
            ],
            dataAjaxUrl: {},
        });
    }
    initDatatable();

    var body = $("body");
    body.on("click", ".btn-add", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Penjualan Cicilan",
            type: "get",
            data: {
                penjualan_id: penjualanId,
            },
        });
    });

    body.on("click", ".btn-detail", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Transaksi",
            type: "get",
        });
    });
});
