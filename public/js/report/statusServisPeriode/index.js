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
            ajaxUrl: `${urlRoot}/report/statusServisPeriode`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "status_histori",
                    name: "status_histori",
                    searchable: true,
                    orderable: true,
                },                
                {
                    data: "total_histori",
                    name: "total_histori",
                    searchable: true,
                    orderable: true,
                },                
            ],
            dataAjaxUrl: {
                dari_tanggal,
                sampai_tanggal,
            },
        });
    }

    initDatatable({ dari_tanggal, sampai_tanggal });


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