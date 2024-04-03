select2Standard({
    parent: "#extraLargeModal",
    selector: "select[name='kategori_id']",
});
select2Standard({
    parent: "#extraLargeModal",
    selector: "select[name='satuan_id']",
});
select2Standard({
    parent: "#extraLargeModal",
    selector: "select[name='snornonsn_barang']",
});
select2Standard({
    parent: "#extraLargeModal",
    selector: "select[name='status_barang']",
});

var hargaJualBarang = new AutoNumeric("input[name='hargajual_barang']", {
    digitGroupSeparator: ",",
    decimalPlaces: 0,
    unformatOnSubmit: true,
});
var stokBarang = new AutoNumeric("input[name='stok_barang']", {
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
    formData.barcode_barang = $('input[name="barcode_barang"]').val();
    formData.nama_barang = $('input[name="nama_barang"]').val();
    formData.deskripsi_barang = $('textarea[name="deskripsi_barang"]').val();
    formData.hargajual_barang = hargaJualBarang.getNumber();
    formData.stok_barang = stokBarang.getNumber();
    formData.kategori_id = $(
        'select[name="kategori_id"] option:selected'
    ).val();

    formData.satuan_id = $('select[name="satuan_id"] option:selected').val();
    formData.snornonsn_barang = $(
        'select[name="snornonsn_barang"] option:selected'
    ).val();
    formData.lokasi_barang = $('input[name="lokasi_barang"]').val();
    formData.status_barang = $(
        'select[name="status_barang"] option:selected'
    ).val();

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
