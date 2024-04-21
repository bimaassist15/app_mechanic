// "use strict";
var datatable;
var myModal;
var body = $("body");

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
                    data: "kendaraan.nopol_kendaraan",
                    name: "kendaraan.nopol_kendaraan",
                    searchable: true,
                },
                {
                    data: "kendaraan.jenis_kendaraan",
                    name: "kendaraan.jenis_kendaraan",
                    searchable: true,
                },
                {
                    data: "kendaraan.tipe_kendaraan",
                    name: "kendaraan.tipe_kendaraan",
                    searchable: true,
                },
                {
                    data: "status_pservis",
                    name: "status_pservis",
                    searchable: true,
                },
                {
                    data: "estimasi_pservis",
                    name: "estimasi_pservis",
                    searchable: false,
                    orderable: false,
                },
                {
                    data: "isrememberestimasi_pservis",
                    name: "isrememberestimasi_pservis",
                    searchable: false,
                    orderable: false,
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

    body.on("click", ".btn-delete", function (e) {
        e.preventDefault();
        basicDeleteConfirmDatatable({
            urlDelete: $(this).attr("href"),
            data: {},
            text: "Apakah anda yakin ingin menghapus item ini?",
        });
    });

    const renderPrintKasir = (setUrl) => {
        var output = "";
        $.ajax({
            url: setUrl,
            dataType: "json",
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
        const output = renderPrintKasir(url);
        printOutput(output);
    });

    body.on("click", ".btn-remember-estimasi", function (e) {
        e.preventDefault();
        const url = $(this).attr("href");
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah anda yakin ingin mengingatkan estimasi servis ini?",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Tidak",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url,
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                        console.log("get data", data);
                        if (data.status == "success") {
                            runToast({
                                type: "bg-success",
                                title: "Berhasil Mengingatkan",
                                message:
                                    "Estimasi servis berhasil diingatkan ke customer",
                            });

                            window.open(data.message, "_blank");
                            datatable.ajax.reload();
                        }
                    },
                });
            }
        });
    });

    body.on("click", ".btn-add", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Penerimaan Service",
            type: "get",
        });
    });

    body.on("click", ".btn-edit", function (e) {
        e.preventDefault();
        showModal({
            url: $(this).attr("href"),
            modalId: $(this).data("typemodal"),
            title: "Form Penerimaan Service",
            type: "get",
        });
    });
});
