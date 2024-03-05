// "use strict";
var datatable;

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
                    data: "customer.nama_customer",
                    name: "customer.nama_customer",
                    searchable: true,
                },
                {
                    data: "customer.nowa_customer",
                    name: "customer.nowa_customer",
                    searchable: true,
                },
                {
                    data: "merek_kendaraan",
                    name: "merek_kendaraan",
                    searchable: true,
                },
                {
                    data: "nopol_kendaraan",
                    name: "nopol_kendaraan",
                    searchable: true,
                },
                {
                    data: "jenis_kendaraan",
                    name: "jenis_kendaraan",
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
            title: "Form Kendaraan",
            type: "get",
        });
    });

    body.on("click", ".btn-delete", function (e) {
        e.preventDefault();
        basicDeleteConfirmDatatable({
            urlDelete: $(this).data("url"),
            data: {},
            text: "Apakah anda yakin ingin menghapus item ini?",
        });
    });

    body.on("click", ".btn-edit", function (e) {
        e.preventDefault();
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Kendaraan",
            type: "get",
        });
    });
});
