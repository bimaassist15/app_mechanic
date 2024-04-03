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
                    data: "noantrian_pservis",
                    name: "noantrian_pservis",
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
    const renderPrint = (url) => {
        var output = "";
        $.ajax({
            url,
            type: "get",
            dataType: "text",
            async: false,
            success: function (data) {
                output = data;
            },
        });
        return output;
    };

    const printOutput = (output) => {
        var printWindow = window.open("", "_blank");
        printWindow.document.write(output);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    };

    body.on("click", ".btn-print", function (e) {
        e.preventDefault();
        const url = $(this).attr("href");
        const output = renderPrint(url);
        printOutput(output);
    });

    body.on("click", ".btn-delete", function (e) {
        e.preventDefault();
        basicDeleteConfirmDatatable({
            urlDelete: $(this).attr("href"),
            data: {},
            text: "Apakah anda yakin ingin menghapus item ini?",
        });
    });
});
