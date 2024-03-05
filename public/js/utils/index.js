var disableButton = `
<div class="spinner-border text-dark" role="status">
<span class="visually-hidden">Loading...</span>
</div>`;

var enableButton = `<i class="fa-regular fa-paper-plane"></i> &nbsp; Submit`;

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
        drawCallback: function () {
            var info = datatable.page.info();
            datatable
                .column(0, { search: "applied", order: "applied" })
                .nodes()
                .each(function (cell, i) {
                    cell.innerHTML = info.start + i + 1;
                });
        },
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
        showCancelButton: true,
        confirmButtonText: "Ya, hapus",
        cancelButtonText: "Tidak",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: urlDelete,
                type: "post",
                dataType: "json",
                data: data,
                success: function (data) {
                    runToast({
                        type: "bg-success",
                        title: "Successfully",
                        description: data,
                    });
                    datatable.ajax.reload();
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

// toastr
// Bootstrap toasts example
// --------------------------------------------------------------------
const toastPlacementExample = document.querySelector(".toast-placement-ex");
const titleToast = document.querySelector(".title-toast");
const descriptionToast = document.querySelector(".description-toast");

let selectedType, selectedPlacement, toastPlacement;

// Dispose toast when open another
function toastDispose(toast) {
    if (toast && toast._element !== null) {
        if (toastPlacementExample) {
            toastPlacementExample.classList.remove(selectedType);
            DOMTokenList.prototype.remove.apply(
                toastPlacementExample.classList,
                selectedPlacement
            );
        }
        toast.dispose();
    }
}
// run toast
var bgType = [
    "bg-primary",
    "bg-secondary",
    "bg-success",
    "bg-danger",
    "bg-warning",
    "bg-info",
    "bg-dark",
];
const runToast = ({ type = "bg-primary", title = "", description = "" }) => {
    if (toastPlacement) {
        toastDispose(toastPlacement);
    }
    selectedType = type;
    selectedPlacement = ["bottom-0", "start-0"];

    toastPlacementExample.classList.add(selectedType);
    DOMTokenList.prototype.add.apply(
        toastPlacementExample.classList,
        selectedPlacement
    );
    toastPlacement = new bootstrap.Toast(toastPlacementExample);
    titleToast.textContent = title;
    descriptionToast.textContent = description;
    toastPlacement.show();
};

clearError422 = () => {
    const getInput = $("#form-submit input");
    if (getInput.length > 0) {
        $.each(getInput, function (index, value) {
            const name = $(this).attr("name");
            $('input[name="' + name + '"]').removeClass("border border-danger");
            $('small[data-name="' + name + '"]').remove();
        });
    }
    const getSelect = $("#form-submit select");
    if (getSelect.length > 0) {
        $.each(getSelect, function (index, value) {
            const name = $(this).attr("name");
            $('select[name="' + name + '"]').removeClass(
                "border border-danger"
            );
            $('small[data-name="' + name + '"]').remove();
        });
    }
    const getTextarea = $("#form-submit textarea");
    if (getTextarea.length > 0) {
        $.each(getTextarea, function (index, value) {
            const name = $(this).attr("name");
            $('textarea[name="' + name + '"]').removeClass(
                "border border-danger"
            );
            $('small[data-name="' + name + '"]').remove();
        });
    }
};

const showErrors422 = (jqXHR) => {
    runToast({
        type: "bg-danger",
        title: "Invalid Form Validation",
        description: "Periksa kembali Form Inputan Anda",
    });

    const responseJSON = jqXHR.responseJSON.errors;
    Object.keys(responseJSON).map((name, index) => {
        const message = responseJSON[name][0];

        var newElement = document.createElement("small");

        newElement.classList.add("text-danger");
        newElement.innerText = message;
        newElement.setAttribute("data-name", name);

        var inputElement = document.querySelector('input[name="' + name + '"]');
        if (inputElement !== null) {
            inputElement.classList.add("border", "border-danger");
            inputElement.parentNode.insertBefore(
                newElement,
                inputElement.nextSibling
            );
        }

        var inputElement = document.querySelector(
            'select[name="' + name + '"]'
        );
        if (inputElement !== null) {
            inputElement.classList.add("border", "border-danger");
            inputElement.parentNode.insertBefore(
                newElement,
                inputElement.nextSibling
            );
        }

        var inputElement = document.querySelector(
            'textarea[name="' + name + '"]'
        );
        if (inputElement !== null) {
            inputElement.classList.add("border", "border-danger");
            inputElement.parentNode.insertBefore(
                newElement,
                inputElement.nextSibling
            );
        }
    });
};