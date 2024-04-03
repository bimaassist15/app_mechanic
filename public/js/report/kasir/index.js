datepickerDdMmYyyy("input[name=dari_tanggal]");
datepickerDdMmYyyy("input[name=sampai_tanggal]");

var urlRoot = $('.url_root').data('value');
var body = $("body");
var datatable;

select2Server({
    selector: "select[name=users_id]",
    parent: ".content-wrapper",
    routing: `${urlRoot}/select/kasir`,
    passData: {},
});

$(document).ready(function () { 
    let dari_tanggal = $("input[name=dari_tanggal]").val();
    if(dari_tanggal != '') {
        dari_tanggal = formatDateToDb(dari_tanggal);
    }

    let sampai_tanggal = $("input[name=sampai_tanggal]").val();
    if(sampai_tanggal != '') {
        sampai_tanggal = formatDateToDb(sampai_tanggal);
    }

    function initDatatable({
            dari_tanggal = dari_tanggal,
            sampai_tanggal = sampai_tanggal,
            users_id = $("select[name=users_id]").val(),
        }) {

        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: `${urlRoot}/report/kasir`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "invoice_penjualan",
                    name: "invoice_penjualan",
                    searchable: true,
                },
                {
                    data: "transaksi_penjualan",
                    name: "transaksi_penjualan",
                    searchable: true,
                },
                {
                    data: "users.name",
                    name: "users.name",
                    searchable: true,
                },
                {
                    data: "total_penjualan",
                    name: "total_penjualan",
                    searchable: false,
                    orderable: false,
                },
            ],
            dataAjaxUrl: {
                dari_tanggal,
                sampai_tanggal,
                users_id,
            },
        });
    }
    initDatatable(
        {
            dari_tanggal,
            sampai_tanggal,
            users_id: $("select[name=users_id]").val()
        }
    );

    body.on('click', '.btn-filter', function (e) {
        e.preventDefault();

        let dari_tanggal = $("input[name=dari_tanggal]").val();
        if(dari_tanggal != '') {
            dari_tanggal = formatDateToDb(dari_tanggal);
        }
    
        let sampai_tanggal = $("input[name=sampai_tanggal]").val();
        if(sampai_tanggal != '') {
            sampai_tanggal = formatDateToDb(sampai_tanggal);
        }

        $('#dataTable').DataTable().destroy();
        $("#dataTable").find("colgroup").remove();

        initDatatable({
            dari_tanggal,
            sampai_tanggal,
            users_id: $("select[name=users_id]").val()
        });
    });
});