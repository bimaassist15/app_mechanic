// "use strict";
var datatable;
var myModal;

var jsonUsersId = $(".usersId").data("value");
var jsonPenerimaanServisId = $(".penerimaanServisId").data("value");
var jsonGetServis = $(".getServis").data("value");
var urlRoot = $(".url_root").data("url");
var renderListServis = () => {};

renderListServis = (data) => {
    let output = ``;
    const { result, totalHargaServis } = data;
    let no = 1;
    result.map((v) => {
        output += `
    <tr>
        <td>${no++}</td>
        <td>${v.harga_servis.kategori_servis.nama_kservis}</td>
        <td>${v.harga_servis.nama_hargaservis}</td>
        <td>${v.users_mekanik != null ? v.users_mekanik.name : "-"}</td>
        <td>${formatUang(v.harga_servis.total_hargaservis)}</td>
        <td>
            <a href="#" 
                data-urlcreate="${urlRoot}/service/orderServis/${v.id}/edit"
                data-typemodal="mediumModal"
                class="btn btn-primary update-users-mekanik btn-small"
                title="Masukan Data Mekanik">
                <i class="fa-solid fa-wrench"></i>
            </a>
            <a href="${urlRoot}/service/orderServis/${
            v.id
        }?_method=delete" data-id="${v.id}"
                class="btn btn-danger delete-order-servis btn-small"
                title="Delete Order Servis">
                <i class="fa-solid fa-trash"></i>
            </a>
        </td>
    </tr>
    `;
    });
    $("#onLoadServis").html(output);
    $("#totalHargaServis").html(formatUang(totalHargaServis));
};

$(document).ready(function () {
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='harga_servis_id']",
    });

    var body = $("body");
    body.on("click", ".detail-customer", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Kendaraan",
            type: "get",
        });
    });

    body.on("click", ".detail-penerimaan-servis", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Kendaraan",
            type: "get",
        });
    });

    body.on("click", ".identitas-kendaraan", function () {
        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Detail Kendaraan",
            type: "get",
        });
    });

    const getListServis = () => {
        $.ajax({
            url: $(".url_get_order_servis").data("url"),
            type: "get",
            dataType: "json",
            data: {
                penerimaan_servis_id: jsonPenerimaanServisId,
            },
            success: function (data) {
                renderListServis(data);
            },
        });
    };
    getListServis();

    body.on("change", "select[name='harga_servis_id']", function () {
        const value = $(this).val();
        if (value === "") {
            return runToast({
                type: "bg-danger",
                description: "Servis wajib diisi",
                title: "Form Validation",
            });
        }

        const getFindData = jsonGetServis.find((item) => item.id == value);

        const payload = {
            users_id: jsonUsersId,
            harga_servis_id: value,
            penerimaan_servis_id: jsonPenerimaanServisId,
            harga_orderservis: getFindData.total_hargaservis,
        };

        $.ajax({
            url: $(".url_order_servis").data("url"),
            type: "post",
            dataType: "json",
            data: payload,
            success: function (data) {
                renderListServis(data);
            },
        });
    });

    body.on("click", ".delete-order-servis", function (e) {
        e.preventDefault();

        basicDeleteConfirmDatatable({
            urlDelete: $(this).attr("href"),
            data: {
                penerimaan_servis_id: jsonPenerimaanServisId,
            },
            text: "Apakah anda yakin ingin menghapus item ini?",
            dataFunction: renderListServis,
        });
    });

    body.on("click", ".update-users-mekanik", function (e) {
        e.preventDefault();

        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Pilih Mekanik",
            type: "get",
            renderData: renderListServis,
        });
    });
});
