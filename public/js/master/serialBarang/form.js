var formSubmit = document.getElementById("form-submit");
formSubmit.addEventListener("submit", function (event) {
    event.preventDefault();
    submitData();
});

function submitData() {
    const formData = {};
    let nomor_serial_barang = $('input[name="nomor_serial_barang"]');
    let status_serial_barang = $('select[name="status_serial_barang"]');

    let push_nomor_serial_barang = [];
    let push_status_serial_barang = [];
    $.each(nomor_serial_barang, function (index, value) {
        let serialValue = $(this).val();
        if (
            serialValue !== "" &&
            serialValue !== undefined &&
            serialValue !== null
        ) {
            push_nomor_serial_barang.push(serialValue);
        }
    });

    $.each(status_serial_barang, function (index, value) {
        let statusValue = $(this).val();
        if (
            statusValue !== "" &&
            statusValue !== undefined &&
            statusValue !== null
        ) {
            push_status_serial_barang.push(statusValue);
        }
    });
    push_nomor_serial_barang = JSON.stringify(push_nomor_serial_barang);
    push_status_serial_barang = JSON.stringify(push_status_serial_barang);

    formData.nomor_serial_barang = push_nomor_serial_barang;
    formData.status_serial_barang = push_status_serial_barang;

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
