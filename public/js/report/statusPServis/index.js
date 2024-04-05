var urlRoot = $('.url_root').data('value');
var body = $("body");
var datatable;

select2Standard({
    selector: "select[name=status_pservis]",
    parent: ".content-wrapper",
});

$(document).ready(function () { 
    function initDatatable({
            status_pservis = $("select[name=status_pservis]").val(),
        }) {

        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: `${urlRoot}/report/statusServis`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "nonota_pservis",
                    name: "nonota_pservis",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "customer.nama_customer",
                    name: "customer.nama_customer",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "created_at",
                    name: "created_at",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "status_pservis",
                    name: "status_pservis",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "mulai_servis",
                    name: "mulai_servis",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "lama_servis",
                    name: "lama_servis",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                    orderable: false,
                },
                
            ],
            dataAjaxUrl: {
                status_pservis,
            },
        });
    }
    initDatatable(
        {
            status_pservis: $("select[name=status_pservis]").val()
        }
    );

    body.on('click', '.btn-filter', function (e) {
        e.preventDefault();

        $('#dataTable').DataTable().destroy();
        $("#dataTable").find("colgroup").remove();

        initDatatable({
            status_pservis: $("select[name=status_pservis]").val()
        });
    });
});