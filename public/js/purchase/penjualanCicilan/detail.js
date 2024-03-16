// "use strict";
var penjualanId = $(".penjualan_id").data("value");
var body = $("body");

$(document).ready(function () {
    const refreshDataSet = () => {
        $.ajax({
            url: $(".url_purchase_kasir").data("url"),
            type: "get",
            data: {
                refresh_dataset: true,
            },
            dataType: "json",
            success: function (data) {
                $(".header_bayar_penjualan").html(
                    number_format(data.getPenjualan.bayar, 0, ".", ",")
                );
                $(".header_hutang_penjualan").html(
                    number_format(data.getPenjualan.hutang, 0, ".", ",")
                );
                $(".header_kembalian_penjualan").html(
                    number_format(data.getPenjualan.kembalian, 0, ".", ",")
                );

                if (data.penjualan.status_transaksi) {
                    $(".btn-add").attr("disabled", true);
                    $(".btn-add").html("Lunas");
                } else {
                    $(".btn-add").attr("disabled", false);
                    $(".btn-add").html(`
                    <span>
                        <i class="bx bx-plus me-sm-1"></i>
                        Tambah
                    </span>
                `);
                }
            },
        });
    };

    const renderPrintKasir = (outputData) => {
        var output = "";
        $.ajax({
            url: $(".btn-print").attr("href"),
            dataType: "json",
            type: "get",
            data: {
                penjualan_id: outputData,
            },
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

    body.off("click", ".btn-print");
    body.on("click", ".btn-print", function (e) {
        e.preventDefault();
        const output = renderPrintKasir(penjualanId);
        printOutput(output);
    });

    body.off("click", ".btn-delete");
    body.on("click", ".btn-delete", function (e) {
        e.preventDefault();
        myModal.hide();

        const url = $(this).attr("href");
        basicDeleteConfirmDatatable({
            urlDelete: url,
            data: {},
            text: "Apakah anda yakin ingin menghapus item ini?",
            dataFunction: refreshDataSet,
        });
    });

    body.off("click", ".btn-edit-transaksi");
    body.on("click", ".btn-edit-transaksi", function (e) {
        e.preventDefault();
        myModal.hide();

        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Penjualan Cicilan",
            type: "get",
            data: {
                penjualan_id: penjualanId,
                isEdit: true,
            },
        });
    });
});
