// "use strict";
var datatable;
var myModal;

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
                    data: "invoice_pembelian",
                    name: "invoice_pembelian",
                    searchable: true,
                },
                {
                    data: "transaksi_pembelian",
                    name: "transaksi_pembelian",
                    searchable: true,
                },
                {
                    data: "supplier",
                    name: "supplier",
                    searchable: true,
                },
                {
                    data: "users.profile.nama_profile",
                    name: "users.profile.nama_profile",
                    searchable: true,
                },
                {
                    data: "total_pembelian",
                    name: "total_pembelian",
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
    // handle btn add data
    body.on("click", ".btn-detail", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Transaksi",
            type: "get",
        });
    });
});
