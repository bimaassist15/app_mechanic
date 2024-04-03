datepickerDdMmYyyy("input[name=dari_tanggal]");
datepickerDdMmYyyy("input[name=sampai_tanggal]");
var body = $("body");
var urlRoot = $('.url_root').data('value');

$(document).ready(function () {    
    const ajaxSubmit = () => {
        var dari_tanggal = $("input[name=dari_tanggal]").val();
        var sampai_tanggal = $("input[name=sampai_tanggal]").val();

        if(dari_tanggal != ''){
            dari_tanggal = formatDateToDb(dari_tanggal);
        }

        if(sampai_tanggal != ''){
            sampai_tanggal = formatDateToDb(sampai_tanggal);
        }


        var data = {
            dari_tanggal: dari_tanggal,
            sampai_tanggal: sampai_tanggal
        };
        $.ajax({
            url: `${urlRoot}/report/labaBersih`,
            type: 'get',
            data: data,
            dataType: 'text',
            beforeSend: function () {
                $(".btn-filter").attr("disabled", true);
                $(".btn-filter").html(disableButton);
            },
            success: function (response) {
                $('#output_result').html(response);
            },
            complete: function () {
                $(".btn-filter").attr("disabled", false);
                $(".btn-filter").html('<i class="fa-solid fa-filter me-2"></i> Filter');
            },
        });
    }
    ajaxSubmit();

    body.on('click', '.btn-filter', function (e) {
        e.preventDefault();
        ajaxSubmit();
    });

    const renderPrint = (payload) => {
        var output = '';
        $.ajax({
            url: `${urlRoot}/report/labaBersih/print`,
            type: 'get',
            data: payload,
            async: false,
            dataType: 'text',
            success: function (response) {
                output = response;
            },
        });
        return output;
    }

    const printOutput = (output) => {
        var printWindow = window.open("", "_blank");
        printWindow.document.write(output);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    };

    body.on('click', '.btn-print', function (e) {
        e.preventDefault();
        var dari_tanggal = $("input[name=dari_tanggal]").val();
        var sampai_tanggal = $("input[name=sampai_tanggal]").val();

        if(dari_tanggal != ''){
            dari_tanggal = formatDateToDb(dari_tanggal);
        }

        if(sampai_tanggal != ''){
            sampai_tanggal = formatDateToDb(sampai_tanggal);
        }

        const output = renderPrint({
            dari_tanggal: dari_tanggal,
            sampai_tanggal: sampai_tanggal
        });

        printOutput(output);
    });
});