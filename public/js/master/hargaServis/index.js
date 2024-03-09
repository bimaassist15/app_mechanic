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
                    data: "kode_hargaservis",
                    name: "kode_hargaservis",
                    searchable: true,
                },
                {
                    data: "nama_hargaservis",
                    name: "nama_hargaservis",
                    searchable: true,
                },
                {
                    data: "kategori_servis.nama_kservis",
                    name: "kategori_servis.nama_kservis",
                    searchable: true,
                },
                {
                    data: "total_hargaservis",
                    name: "total_hargaservis",
                    searchable: true,
                },
                {
                    data: "status_hargaservis",
                    name: "status_hargaservis",
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
            title: "Form Harga Servis",
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
            title: "Form Harga Servis",
            type: "get",
        });
    });
});
