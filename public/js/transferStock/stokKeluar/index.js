var datatable;
var urlRoot = $("url_root").data("value");
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
                    data: "kode_tstock",
                    name: "kode_tstock",
                    searchable: true,
                },
                {
                    data: "created_at",
                    name: "created_at",
                    searchable: true,
                },
                {
                    data: "cabang_id_awal",
                    name: "cabang_id_awal",
                    searchable: true,
                },
                {
                    data: "cabang_id_penerima",
                    name: "cabang_id_penerima",
                    searchable: true,
                },
                {
                    data: "status_tstock",
                    name: "status_tstock",
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
