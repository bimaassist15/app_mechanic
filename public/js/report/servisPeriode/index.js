datepickerDdMmYyyy("input[name=dari_tanggal]");
datepickerDdMmYyyy("input[name=sampai_tanggal]");

var urlRoot = $('.url_root').data('value');
var body = $("body");
var datatable;


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
        }) {

        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: `${urlRoot}/report/servisPeriode`,
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
                    data: "nama_hargaservis",
                    name: "nama_hargaservis",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "nama_mekanik",
                    name: "nama_mekanik",
                    searchable: true,
                    orderable: true,
                },
                {
                    data: "total_hargaservis",
                    name: "total_hargaservis",
                    searchable: false,
                    orderable: true,
                },
                {
                    data: "profit_hargaservis",
                    name: "profit_hargaservis",
                    searchable: false,
                    orderable: true,
                },
                {
                    data: "jasa_hargaservis",
                    name: "jasa_hargaservis",
                    searchable: false,
                    orderable: true,
                },
            ],
            dataAjaxUrl: {
                dari_tanggal,
                sampai_tanggal,
            },
        });
    }
    initDatatable(
        {
            dari_tanggal,
            sampai_tanggal,
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

        $('.output_dari_tanggal').text(formatDateIndonesia(dari_tanggal));
        $('.output_sampai_tanggal').text(formatDateIndonesia(sampai_tanggal));

        $('#dataTable').DataTable().destroy();
        $("#dataTable").find("colgroup").remove();

        initDatatable({
            dari_tanggal,
            sampai_tanggal,
        });
    });
});