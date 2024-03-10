// "use strict";
var datatable;

$(document).ready(function () {
    function initDatatable() {
        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: $(".url_datatable").data("url"),
            scrollX: true,
            autoWidth: false,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "nama_spembayaran",
                    name: "nama_spembayaran",
                    searchable: true,
                },
                {
                    data: "kategori_pembayaran.nama_kpembayaran",
                    name: "kategori_pembayaran.nama_kpembayaran",
                    searchable: true,
                },
                {
                    data: "status_spembayaran",
                    name: "status_spembayaran",
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

    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='kategori_pembayaran_id_filter']",
    });

    var body = $("body");
    // handle btn add data
    body.on("click", ".btn-add", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Sub Pembayaran",
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
            title: "Form Sub Pembayaran",
            type: "get",
        });
    });

    body.on(
        "change",
        'select[name="kategori_pembayaran_id_filter"]',
        function (e) {
            const value = $(this).val();
            $("#dataTable").DataTable().destroy();
            $("#dataTable").find("colgroup").remove();

            datatable = basicDatatable({
                tableId: $("#dataTable"),
                ajaxUrl: $(".url_datatable").data("url"),
                scrollX: true,
                autoWidth: false,
                columns: [
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        className: "text-center",
                    },
                    {
                        data: "nama_spembayaran",
                        name: "nama_spembayaran",
                        searchable: true,
                    },
                    {
                        data: "kategori_pembayaran.nama_kpembayaran",
                        name: "kategori_pembayaran.nama_kpembayaran",
                        searchable: true,
                    },
                    {
                        data: "status_spembayaran",
                        name: "status_spembayaran",
                        searchable: true,
                    },
                    {
                        data: "action",
                        name: "action",
                        searchable: false,
                        orderable: false,
                    },
                ],
                dataAjaxUrl: {
                    kategori_pembayaran_id: value,
                },
            });
        }
    );
});
