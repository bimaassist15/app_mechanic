// "use strict";
var datatable;

$(document).ready(function () {
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='cabang_id']",
    });

    function initDatatable() {
        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: $(".url_datatable").data("url"),
            scrollX: true,
            autoWidth: false,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "profile.nama_profile",
                    name: "profile.nama_profile",
                    searchable: true,
                },
                {
                    data: "profile.nohp_profile",
                    name: "profile.nohp_profile",
                    searchable: true,
                },
                {
                    data: "email",
                    name: "email",
                    searchable: true,
                },
                {
                    data: "roles_name",
                    name: "roles_name",
                    searchable: true,
                },
                {
                    data: "status_users",
                    name: "status_users",
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

    var body = $("body");
    // handle btn add data
    body.on("click", ".btn-add", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form User",
            type: "get",
        });
    });

    body.on("click", ".btn-delete", function (e) {
        e.preventDefault();
        basicDeleteConfirmDatatable({
            urlDelete: $(this).data("url"),
            data: {},
            text: "Apakah anda yakin ingin menghapus item ini?",
        });
    });

    body.on("click", ".btn-edit", function (e) {
        e.preventDefault();
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form User",
            type: "get",
        });
    });

    body.on("change", 'select[name="cabang_id"]', function (e) {
        const value = $(this).val();
        $("#dataTable").DataTable().destroy();
        $("#dataTable").find("colgroup").remove();

        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: $(".url_datatable").data("url"),
            scrollX: true,
            autoWidth: false,
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "profile.nama_profile",
                    name: "profile.nama_profile",
                    searchable: true,
                },
                {
                    data: "profile.nohp_profile",
                    name: "profile.nohp_profile",
                    searchable: true,
                },
                {
                    data: "email",
                    name: "email",
                    searchable: true,
                },
                {
                    data: "roles_name",
                    name: "roles_name",
                    searchable: true,
                },
                {
                    data: "status_users",
                    name: "status_users",
                    searchable: true,
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                    orderable: false,
                },
            ],
            dataAjaxUrl: {
                cabang_id: value,
            },
        });
    });
});
