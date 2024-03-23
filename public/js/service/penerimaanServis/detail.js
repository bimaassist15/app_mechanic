// "use strict";
var datatable;
var myModal;

$(document).ready(function () {
    var body = $("body");
    body.on("click", ".detail-customer", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Kendaraan",
            type: "get",
        });
    });

    body.on("click", ".detail-penerimaan-servis", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Kendaraan",
            type: "get",
        });
    });

    body.on("click", ".identitas-kendaraan", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Kendaraan",
            type: "get",
        });
    });
});
