// "use strict";
var datatable;
var body = $("body");
var urlRoot = $(".url_root").data("value");
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
                    data: "nonota_pservis",
                    name: "nonota_pservis",
                    searchable: true,
                },
                {
                    data: "kendaraan.customer.nama_customer",
                    name: "kendaraan.customer.nama_customer",
                    searchable: true,
                },
                {
                    data: "created_at",
                    name: "created_at",
                    searchable: true,
                },
                {
                    data: "servisberkala_pservis",
                    name: "servisberkala_pservis",
                    searchable: true,
                },
                {
                    data: "status_pservis",
                    name: "status_pservis",
                    searchable: true,
                },
                {
                    data: "is_reminded",
                    name: "is_reminded",
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

    body.on("click", ".btn-send-wa", function (e) {
        e.preventDefault();
        const id = $(this).data("id");
        const href = $(this).attr("href");
        $.ajax({
            url: `${urlRoot}/service/berkala/setReminded/${id}/update?_method=PUT`,
            type: "post",
            success: function () {
                window.open(href, "_blank");
                datatable.ajax.reload();
            },
        });
    });
});
