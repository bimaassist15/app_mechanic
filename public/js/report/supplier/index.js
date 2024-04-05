datepickerDdMmYyyy("input[name=dari_tanggal]");
datepickerDdMmYyyy("input[name=sampai_tanggal]");

var urlRoot = $('.url_root').data('value');
var body = $("body");
var datatable;

select2Server({
    selector: "select[name=supplier_id]",
    parent: ".content-wrapper",
    routing: `${urlRoot}/select/supplier`,
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
            supplier_id = $("select[name=supplier_id]").val(),
        }) {

        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: `${urlRoot}/report/supplier`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "invoice_pembelian",
                    name: "invoice_pembelian",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "transaksi_pembelian",
                    name: "transaksi_pembelian",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "supplier.nama_supplier",
                    name: "supplier.nama_supplier",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "total_pembayaran",
                    name: "total_pembayaran",
                    searchable: false,
                    orderable: false,
                },
            ],
            dataAjaxUrl: {
                dari_tanggal,
                sampai_tanggal,
                supplier_id,
            },
        });
    }
    initDatatable(
        {
            dari_tanggal,
            sampai_tanggal,
            supplier_id: $("select[name=supplier_id]").val()
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
            supplier_id: $("select[name=supplier_id]").val()
        });
    });
});