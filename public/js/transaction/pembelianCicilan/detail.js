// "use strict";
var pembelianId = $(".pembelian_id").data("value");
var body = $("body");

$(document).ready(function () {
    const refreshDataSet = () => {
        $.ajax({
            url: $(".url_transaction_kasir").data("url"),
            type: "get",
            data: {
                refresh_dataset: true,
            },
            dataType: "json",
            success: function (data) {
                $(".header_bayar_pembelian").html(
                    number_format(data.getPembelian.bayar, 0, ".", ",")
                );
                $(".header_hutang_pembelian").html(
                    number_format(data.getPembelian.hutang, 0, ".", ",")
                );
                $(".header_kembalian_pembelian").html(
                    number_format(data.getPembelian.kembalian, 0, ".", ",")
                );

                if (data.getPembelian.status_transaksi) {
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
                pembelian_id: outputData,
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
        const output = renderPrintKasir(pembelianId);
        console.log("get output", output);
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
                pembelian_id: pembelianId,
                isEdit: true,
            },
        });
    });
});
