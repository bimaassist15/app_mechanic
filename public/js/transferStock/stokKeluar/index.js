var datatable;
var urlRoot = $(".url_root").data("value");
var body = $("body");

$(document).ready(function () {
    function initDatatable() {
        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: $(".url_datatable").data("url"),
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "kode_tstock",
                    name: "kode_tstock",
                    searchable: true,
                },
                {
                    data: "created_at",
                    name: "created_at",
                    searchable: true,
                },
                {
                    data: "cabang_pemberi.nama_cabang",
                    name: "cabang_pemberi.nama_cabang",
                    searchable: true,
                },
                {
                    data: "cabang_penerima.nama_cabang",
                    name: "cabang_penerima.nama_cabang",
                    searchable: true,
                },
                {
                    data: "status_tstock",
                    name: "status_tstock",
                    searchable: true,
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                    orderable: false,
                },
            ],
            dataAjaxUrl: {},
        });
    }
    initDatatable();

    body.on("click", ".btn-detail", function (e) {
        e.preventDefault();

        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Transfer Stok Barang",
            type: "get",
        });
    });

    const renderPrint = (id) => {
        var output = "";
        $.ajax({
            url: `${urlRoot}/transferStock/keluar/${id}/print`,
            type: "get",
            dataType: "text",
            async: false,
            success: function (data) {
                output = data;
            },
        });
        return output;
    };

    const printOutput = (output) => {
        var printWindow = window.open("", "_blank");
        printWindow.document.write(output);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    };

    body.on("click", ".btn-print", function (e) {
        e.preventDefault();
        const id = $(this).data("id");
        const output = renderPrint(id);
        printOutput(output);
    });

    const checkStatusTransfer = (payload) => {
        var output = false;
        $.ajax({
            url: `${urlRoot}/transferStock/keluar/checkStatus/validation`,
            type: "get",
            dataType: "json",
            data: payload,
            async: false,
            success: function (data) {
                output = data;
            },
        });
        return output;
    };

    body.on("click", ".btn-delete", function (e) {
        e.preventDefault();
        myModal.hide();

        const id = $(this).data("id");
        const outputCheckStatus = checkStatusTransfer({
            id: id,
        });

        if (!outputCheckStatus.result) {
            return runToast({
                title: "Form Validation",
                description: outputCheckStatus.message,
                type: "bg-danger",
            });
        }

        basicDeleteConfirmDatatable({
            urlDelete: `${urlRoot}/transferStock/keluar/${id}/destroy?_method=DELETE`,
            data: {},
            text: "Apakah anda yakin ingin menghapus item ini?",
        });
    });

    body.on("click", ".btn-edit", function (e) {
        e.preventDefault();

        const id = $(this).data("id");
        const outputCheckStatus = checkStatusTransfer({
            id: id,
        });

        if (!outputCheckStatus.result) {
            return runToast({
                title: "Form Validation",
                description: outputCheckStatus.message,
                type: "bg-danger",
            });
        }

        window.location.href = `${urlRoot}/transferStock/transaksi?isEdit=true&id=${id}`;
        myModal.hide();
    });
});
