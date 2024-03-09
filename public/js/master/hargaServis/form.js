select2Standard({
    parent: "#extraLargeModal",
    selector: "select[name='kategori_servis_id']",
});
var jasaHargaServis = new AutoNumeric("input[name='jasa_hargaservis']", {
    digitGroupSeparator: ",",
    decimalPlaces: 0,
    unformatOnSubmit: true,
});
var profitHargaServis = new AutoNumeric("input[name='profit_hargaservis']", {
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
    const formData = {};
    formData.kode_hargaservis = $('input[name="kode_hargaservis"]').val();
    formData.nama_hargaservis = $('input[name="nama_hargaservis"]').val();
    formData.deskripsi_hargaservis = $(
        'textarea[name="deskripsi_hargaservis"]'
    ).val();
    formData.kategori_servis_id = $('select[name="kategori_servis_id"]').val();
    formData.jasa_hargaservis = jasaHargaServis.getNumber();
    formData.profit_hargaservis = profitHargaServis.getNumber();
    formData.status_hargaservis = $(
        'input[name="status_hargaservis"]:checked'
    ).val();
    formData.total_hargaservis =
        jasaHargaServis.getNumber() + profitHargaServis.getNumber();

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
