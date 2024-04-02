select2Standard({
    parent: "#mediumModal",
    selector: "select[name='kategori_pengeluaran_id']",
});

datepickerDdMmYyyy('input[name="tanggal_tpengeluaran"]')

var jumlahTPendapatan = new AutoNumeric("input[name='jumlah_tpengeluaran']", {
    digitGroupSeparator: ",",
    decimalPlaces: 0,
    unformatOnSubmit: true,
});

var formSubmit = document.getElementById("form-submit");

formSubmit.addEventListener("submit", function (event) {
    event.preventDefault();
    submitData();
});



function submitData() {
    const tanggalTpengeluaran = $('input[name="tanggal_tpengeluaran"]').val();

    let formData = {};
    formData.kategori_pengeluaran_id = $('select[name="kategori_pengeluaran_id"]').val();
    formData.jumlah_tpengeluaran = jumlahTPendapatan.getNumber();
    formData.tanggal_tpengeluaran = formatDateToDb(tanggalTpengeluaran);
    
    $.ajax({
        type: "post",
        url: $("#form-submit").attr("action"),
        data: formData,
        dataType: "json",
        beforeSend: function () {
            clearError422();
            $("#btn-submit").attr("disabled", true);
            $("#btn-submit").html(disableButton);
        },
        success: function (data) {
            myModal.hide();
            runToast({
                title: "Successfully",
                description: data,
                type: "bg-success",
            });
            datatable.ajax.reload();
        },
        error: function (jqXHR, exception) {
            $("#btn-submit").attr("disabled", false);
            $("#btn-submit").html(enableButton);
            if (jqXHR.status === 422) {
                showErrors422(jqXHR);
            }
        },
        complete: function () {
            $("#btn-submit").attr("disabled", false);
            $("#btn-submit").html(enableButton);
        },
    });
}
