// "use strict";
var datatable;

$(document).ready(function () {
    function initDatatable() {
        datatable = basicDatatable(
            $("#dataTable"),
            $(".url_datatable").data("url"),
            [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "nama_kategori",
                    name: "nama_kategori",
                    searchable: true,
                },
                {
                    data: "status_kategori",
                    name: "status_kategori",
                    searchable: true,
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                    orderable: false,
                },
            ]
        );
    }
    // initDatatable();

    var body = $("body");
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='cabang_awal_id']",
    });
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='cabang_penerima_id']",
    });
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='kode_barang']",
    });
});
