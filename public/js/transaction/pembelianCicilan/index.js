// "use strict";
var datatable;
var myModal;
var pembelianId = $(".pembelian_id").data("value");

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
                    data: "bayar_pbcicilan",
                    name: "bayar_pbcicilan",
                    searchable: true,
                },
                {
                    data: "users.profile.nama_profile",
                    name: "users.profile.nama_profile",
                    searchable: true,
                },
                {
                    data: "hutang_pbcicilan",
                    name: "hutang_pbcicilan",
                    searchable: true,
                },
                {
                    data: "kembalian_pbcicilan",
                    name: "kembalian_pbcicilan",
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
            title: "Form Pembelian Cicilan",
            type: "get",
            data: {
                pembelian_id: pembelianId,
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
