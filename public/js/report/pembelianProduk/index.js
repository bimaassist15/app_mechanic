datepickerDdMmYyyy("input[name=dari_tanggal]");
datepickerDdMmYyyy("input[name=sampai_tanggal]");

var urlRoot = $('.url_root').data('value');
var body = $("body");
var datatable;

select2Server({
    selector: "select[name=barang_id]",
    parent: ".content-wrapper",
    routing: `${urlRoot}/select/barang`,
    passData: {
        status_barang: 'dijual,dijual & untuk servis,khusus servis'
    },
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
            barang_id = $("select[name=barang_id]").val(),
        }) {

        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: `${urlRoot}/report/pembelianProduk`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "transaksi_pembelianproduct",
                    name: "transaksi_pembelianproduct",
                    searchable: false,
                    orderable: true,
                },
                {
                    data: "nama_barang",
                    name: "nama_barang",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "total_sum",
                    name: "total_sum",
                    searchable: false,
                    orderable: true,
                },
            ],
            dataAjaxUrl: {
                dari_tanggal,
                sampai_tanggal,
                barang_id,
            },
        });
    }
    initDatatable(
        {
            dari_tanggal,
            sampai_tanggal,
            barang_id: $("select[name=barang_id]").val()
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
            barang_id: $("select[name=barang_id]").val()
        });
    });
});