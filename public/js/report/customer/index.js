datepickerDdMmYyyy("input[name=dari_tanggal]");
datepickerDdMmYyyy("input[name=sampai_tanggal]");

var urlRoot = $('.url_root').data('value');
var body = $("body");
var datatable;

select2Server({
    selector: "select[name=customer_id]",
    parent: ".content-wrapper",
    routing: `${urlRoot}/select/customer`,
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
            customer_id = $("select[name=customer_id]").val(),
        }) {

        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: `${urlRoot}/report/customer`,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "nama_customer",
                    name: "nama_customer",
                    searchable: true,
                },
                {
                    data: "nowa_customer",
                    name: "nowa_customer",
                    searchable: true,
                },
                {
                    data: "alamat_customer",
                    name: "alamat_customer",
                    searchable: true,
                },
                {
                    data: "saldo_customer.jumlah_saldocustomer",
                    name: "saldo_customer.jumlah_saldocustomer",
                    searchable: false,
                    orderable: false,
                },
                {
                    data: "jumlah_pembelian",
                    name: "jumlah_pembelian",
                    searchable: false,
                    orderable: false,
                },
                {
                    data: "total_pembelian",
                    name: "total_pembelian",
                    searchable: false,
                    orderable: false,
                },
                {
                    data: "hutang_pembelian",
                    name: "hutang_pembelian",
                    searchable: false,
                    orderable: false,
                },

                {
                    data: "jumlah_servis",
                    name: "jumlah_servis",
                    searchable: false,
                    orderable: false,
                },
                {
                    data: "total_servis",
                    name: "total_servis",
                    searchable: false,
                    orderable: false,
                },
                {
                    data: "hutang_servis",
                    name: "hutang_servis",
                    searchable: false,
                    orderable: false,
                },
            ],
            dataAjaxUrl: {
                dari_tanggal,
                sampai_tanggal,
                customer_id,
            },
        });
    }
    initDatatable(
        {
            dari_tanggal,
            sampai_tanggal,
            customer_id: $("select[name=customer_id]").val()
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
            customer_id: $("select[name=customer_id]").val()
        });
    });
});