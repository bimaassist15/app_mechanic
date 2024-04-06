// "use strict";
var datatable;
var pembelianId = $(".pembelian_id").data("value");
var body = $("body");
var urlRoot = $(".url_root").data("value");

$(document).ready(function () {
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
        printOutput(output);
    });

    body.off("click", ".btn-jatuh-tempo");
    body.on("click", ".btn-jatuh-tempo", function (e) {
        e.preventDefault();
        const id = $(this).data("id");
        myModal.hide();

        showModal({
            url: `${urlRoot}/transaction/belumLunas/${id}/jatuhTempo`,
            modalId: $(this).data("modalid"),
            title: "Pesan Jatuh Tempo",
            type: "get",
        });
    });

    body.off("click", ".btn-remember-supplier a");
    body.on("click", ".btn-remember-supplier a", function (e) {
        e.preventDefault();
        const id = $(".btn-remember-supplier").data("id");
        const href = $(this).attr("href");

        $.ajax({
            url: `${urlRoot}/transaction/belumLunas/${id}/remember?_method=PUT`,
            type: "post",
            success: function (response) {
                runToast({
                    type: "bg-success",
                    title: "Successfully",
                    description: response,
                });
                $(".btn-remember-supplier").addClass("d-none");
                $(".output_isinfojtempo_pembelian").removeClass("d-none");
                window.open(href, "_blank");
            },
        });
    });
});
