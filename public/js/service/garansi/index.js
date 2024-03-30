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
                    data: "status_pservis",
                    name: "status_pservis",
                    searchable: true,
                },
                {
                    data: "tanggalambil_pservis",
                    name: "tanggalambil_pservis",
                    searchable: true,
                },
                {
                    data: "servisgaransi_pservis",
                    name: "servisgaransi_pservis",
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
});
