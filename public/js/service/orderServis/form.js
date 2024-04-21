select2Standard({
    parent: "#mediumModal",
    selector: "select[name='users_id_mekanik']",
});

var formSubmit = document.getElementById("form-submit");

formSubmit.addEventListener("submit", function (event) {
    event.preventDefault();
    submitData();
});

function submitData() {
    const get_users_id_mekanik = $('select[name="users_id_mekanik"]').val();
    if (get_users_id_mekanik == "") {
        return runToast({
            type: "bg-danger",
            title: "Form Validation",
            description: "Mekanik wajib diisi",
        });
    }

    const formData = $("#form-submit").serialize();
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
                description: data.message,
                type: "bg-success",
            });
            viewRenderServis();
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
