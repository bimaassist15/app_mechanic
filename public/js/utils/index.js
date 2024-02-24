var disableButton = `
<div class="spinner-border text-primary" role="status">
<span class="visually-hidden">Loading...</span>
</div>`;

var enableButton = `<i class="fa-regular fa-paper-plane"></i> Submit`;

function ajaxErrorMessage(jqXHR, exception) {
    var msgerror = "";
    if (jqXHR.status === 0) {
        msgerror = "Koneksi tidak stabil/ terputus.";
    } else if (jqXHR.status == 404) {
        msgerror = "Halaman tidak ditemukan.";
    } else if (jqXHR.status == 500) {
        msgerror = "Kesalahan pada server.";
    } else if (exception === "parsererror") {
        msgerror = "Gagal parsing JSON.";
    } else if (exception === "timeout") {
        msgerror = "Waktu request habis (Request Time Out)";
    } else if (exception === "abort") {
        msgerror = "Gagal ajax request.";
    } else {
        msgerror = "Error.\n" + jqXHR.responseJSON.message;
    }

    Swal.fire({
        title: jqXHR.statusText,
        text: msgerror,
        icon: "error",
        confirmButtonText: "OK",
    });
}

function notifAlert({ title = "", text = "", icon = "" }) {
    Swal.fire({
        title,
        text,
        icon,
        confirmButtonText: "OK",
    });
}

function basicDatatable({
    tableId = "",
    ajaxUrl = "",
    columns = "",
    dataAjaxUrl = {},
}) {
    return tableId.DataTable({
        serverSide: true,
        processing: true,
        searching: true,
        ajax: {
            url: ajaxUrl,
            type: "get",
            dataType: "json",
            data: dataAjaxUrl,
        },
        columns: columns,
    });
}

/**
 * Basic Confirm Message on Delete Action Form
 * @param {*} urlDelete
 * @param {*} data
 */
function basicDeleteConfirmDatatable({ urlDelete = "", data = {}, text = "" }) {
    var text = text ? text : "Benar ingin menghapus data ini?";

    Swal.fire({
        title: "Konfirmasi",
        text: text,
        icon: "warning",
        dangerMode: true,
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlDelete,
                type: "post",
                dataType: "json",
                data: data,
                beforeSend: function () {},
                success: function (data) {
                    notifAlert("Successfully", data, "success");
                },
                error: function (jqXHR, exception) {
                    ajaxErrorMessage(jqXHR, exception);
                },
            });
        }
    });
}

function onRemoveSpace(text) {
    text.value = text.value.replace(/\s+/g, "");
}

function textareaTrim(pane) {
    $.trim(pane.val())
        .replace(/\s*[\r\n]+\s*/g, "\n")
        .replace(/(<[^\/][^>]*>)\s*/g, "$1")
        .replace(/\s*(<\/[^>]+>)/g, "$1");
}

function select2Standard({
    selector = "",
    parent = "",
    theme = "bootstrap-5",
}) {
    $(`${selector}`).select2({
        dropdownParent: $(`${parent}`),
        closeOnSelect: true,
        theme: theme,
    });
}

function select2Server({
    selector = "",
    parent = "",
    routing = "",
    passData = {},
}) {
    function formatRepo(repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +
                "<div class='select2-result-repository__meta'>" +
                "<div class='select2-result-repository__title'></div>" +
                "</div>" +
                "</div>" +
                "</div>"
        );

        $container.find(".select2-result-repository__title").text(repo.text);
        return $container;
    }

    function formatRepoSelection(repo) {
        return repo.text;
    }

    $(`${selector}`).select2({
        dropdownParent: $(`${parent}`),
        closeOnSelect: true,
        theme: "bootstrap-5",
        ajax: {
            url: `${routing}`,
            dataType: "json",
            data: function (params) {
                let setData = {
                    search: params.term,
                    page: params.page || 1,
                };
                return {
                    ...setData,
                    ...passData,
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: params.page * 10 < data.count_filtered,
                    },
                };
            },
            cache: true,
        },
        templateResult: formatRepo,
        templateSelection: formatRepoSelection,
    });
}
