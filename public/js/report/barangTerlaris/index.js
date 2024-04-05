
var urlRoot = $('.url_root').data('value');
var body = $("body");
var datatable;


$(document).ready(function () { 

    function initDatatable() {
        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: `${urlRoot}/report/barangTerlaris`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "barcode_barang",
                    name: "barcode_barang",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "nama_barang",
                    name: "nama_barang",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "kategori.nama_kategori",
                    name: "kategori.nama_kategori",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "hargajual_barang",
                    name: "hargajual_barang",
                    searchable: false,
                    orderable: true,
                },
                {
                    data: "total_sum",
                    name: "total_sum",
                    searchable: false,
                    orderable: true,
                },
                {
                    data: "satuan.nama_satuan",
                    name: "satuan.nama_satuan",
                    searchable: true,
                    orderable: true,
                },
            ],
            dataAjaxUrl: {
            },
        });
    }
    initDatatable();

    body.on('click', '.btn-filter', function (e) {
        e.preventDefault();
        $('#dataTable').DataTable().destroy();
        $("#dataTable").find("colgroup").remove();

        initDatatable();
    });
});