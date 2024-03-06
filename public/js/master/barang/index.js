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
                    data: "barcode_barang",
                    name: "barcode_barang",
                    searchable: true,
                },
                {
                    data: "nama_barang",
                    name: "nama_barang",
                    searchable: true,
                },
                {
                    data: "kategori.nama_kategori",
                    name: "kategori.nama_kategori",
                    searchable: true,
                },
                {
                    data: "hargajual_barang",
                    name: "hargajual_barang",
                    searchable: true,
                },
                {
                    data: "stok_barang",
                    name: "stok_barang",
                    searchable: true,
                },
                {
                    data: "status_barang",
                    name: "status_barang",
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
            title: "Form Barang",
            type: "get",
        });
    });

    body.on("click", ".btn-delete", function (e) {
        e.preventDefault();
        myModal.hide();
        basicDeleteConfirmDatatable({
            urlDelete: $(this).data("url"),
            data: {},
            text: "Apakah anda yakin ingin menghapus item ini?",
        });
    });

    body.on("click", ".btn-edit", function (e) {
        e.preventDefault();
        myModal.hide();
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Barang",
            type: "get",
        });
    });

    body.on("click", ".btn-detail", function (e) {
        e.preventDefault();
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Barang",
            type: "get",
        });
    });
});
