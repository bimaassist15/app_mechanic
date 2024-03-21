// "use strict";
var datatable;
var myModal;

$(document).ready(function () {
    var body = $("body");
    body.on("click", ".detail-kendaraan", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Kendaraan",
            type: "get",
        });
    });
});
