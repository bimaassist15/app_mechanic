var urlRoot = $(".url_root").data("value");
var idData = $(".id").data("value");
select2Standard({
    selector: 'select[name="status_tstock"]',
    parent: "#extraLargeModal",
});

var formSubmit = document.getElementById("form-submit");
formSubmit.addEventListener("submit", function (event) {
    event.preventDefault();
    submitData();
});

function submitData() {
    const status_tstock = $('select[name="status_tstock"]').val();
    if (status_tstock === "") {
        return runToast({
            title: "Form Validation",
            description: "Status Transfer Stok tidak boleh kosong",
            type: "bg-danger",
        });
    }

    const formData = {};
    formData.status_tstock = status_tstock;

    $.ajax({
        type: "post",
        url: `${urlRoot}/transferStock/masuk/${idData}/updateStatus?_method=PUT`,
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
