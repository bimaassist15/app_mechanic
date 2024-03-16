// "use strict";
var datatable;
var pembelianId = $(".pembelian_id").data("value");
var body = $("body");

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
});
