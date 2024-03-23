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
                    data: "nama_customer",
                    name: "nama_customer",
                    searchable: true,
                },
                {
                    data: "nowa_customer",
                    name: "nowa_customer",
                    searchable: true,
                },
                {
                    data: "penjualan_count",
                    name: "penjualan_count",
                    searchable: true,
                },
                {
                    data: "penerimaan_servis_count",
                    name: "penerimaan_servis_count",
                    searchable: true,
                },
                {
                    data: "status_customer",
                    name: "status_customer",
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
    body.on("click", ".btn-add", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Customer",
            type: "get",
        });
    });

    body.on("click", ".btn-delete", function (e) {
        e.preventDefault();
        basicDeleteConfirmDatatable({
            urlDelete: $(this).attr("href"),
            data: {},
            text: "Apakah anda yakin ingin menghapus item ini?",
        });
    });

    body.on("click", ".btn-edit", function (e) {
        e.preventDefault();
        showModal({
            url: $(this).attr("href"),
            modalId: $(this).data("typemodal"),
            title: "Form Customer",
            type: "get",
        });
    });

    body.on("click", ".btn-detail", function (e) {
        e.preventDefault();
        showModal({
            url: $(this).attr("href"),
            modalId: $(this).data("typemodal"),
            title: "Detail Customer",
            type: "get",
        });
    });
});
