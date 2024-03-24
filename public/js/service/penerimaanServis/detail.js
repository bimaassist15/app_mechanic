// "use strict";
var datatable;
var myModal;

var jsonUsersId = $(".usersId").data("value");
var jsonPenerimaanServisId = $(".penerimaanServisId").data("value");
var jsonGetServis = $(".getServis").data("value");
var jsonGetBarang = $(".getBarang").data("value");
var jsonTipeDiskon = $(".getTipeDiskon").data("value");
var urlRoot = $(".url_root").data("url");
var renderListServis = () => {};
var renderListBarang = () => {};
var setOrderBarang = [];

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

renderListBarang = (data) => {
    let output = ``;
    const { result, totalHargaBarang } = data;
    let no = 1;
    result.map((v) => {
        setOrderBarang.push({
            id: v.id,
            barang_id: v.barang.id,
            nama_barang: v.barang.nama_barang,
            hargajual_barang: v.barang.hargajual_barang,
            stok_barang: v.barang.stok_barang,
            qty_orderbarang: v.qty_orderbarang,
            typediskon_orderbarang:
                v.typediskon_orderbarang == null
                    ? ""
                    : v.typediskon_orderbarang,
            diskon_orderbarang:
                v.diskon_orderbarang == null ? 0 : v.diskon_orderbarang,
            subtotal_orderbarang: v.subtotal_orderbarang,
        });

        output += `
    <tr>
        <td>${no++}</td>
        <td>${v.barang.nama_barang}</td>
        <td>${formatUang(v.barang.hargajual_barang)}</td>
        <td>
            <input
                name="qty_orderbarang"
                class="qty_orderbarang form-control" 
                data-id="${v.id}" 
                value="${formatUang(v.qty_orderbarang)}"
                title="Stok Barang: ${v.barang.stok_barang}"
                />
        </td>
        <td>
            <select name="typediskon_orderbarang" class="form-select" data-id="${
                v.id
            }">
                <option value="" selected>Tipe Diskon</option>`;
        Object.keys(jsonTipeDiskon).map((item, i) => {
            output += `
                    <option value="${item}" ${
                v.typediskon_orderbarang == item ? "selected" : ""
            }>${jsonTipeDiskon[item]}</option>
                    `;
        });

        output += `
            </select>
        </td>
        <td>
            <input
                name="diskon_orderbarang"
                class="diskon_orderbarang form-control" 
                data-id="${v.id}" 
                value="${
                    v.diskon_orderbarang == null
                        ? ""
                        : formatUang(v.diskon_orderbarang)
                }"
                ${v.typediskon_orderbarang == null ? "disabled" : ""} />
        </td>
        <td>
            <span class="output_subtotal_orderbarang" data-id="${v.id}">
                ${formatUang(v.subtotal_orderbarang)}
            </span>
        </td>
        <td>
            <a href="${urlRoot}/service/orderBarang/${
            v.id
        }?_method=delete" data-id="${v.id}"
                class="btn btn-danger delete-order-barang btn-small"
                title="Delete Order Servis">
                <i class="fa-solid fa-trash"></i>
            </a>
        </td>
    </tr>
    `;
    });
    $("#loadOrderBarang").html(output);
    $("#totalHargaBarang").html(formatUang(totalHargaBarang));
};

$(document).ready(function () {
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='harga_servis_id']",
    });
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='barang_id']",
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

    // barang
    const getListBarang = () => {
        $.ajax({
            url: `${urlRoot}/service/orderBarang`,
            type: "get",
            dataType: "json",
            data: {
                penerimaan_servis_id: jsonPenerimaanServisId,
            },
            success: function (data) {
                renderListBarang(data);
            },
        });
    };
    getListBarang();

    body.on("change", "select[name='barang_id']", function () {
        const value = $(this).val();

        // handle input qty
        const findIndexOrderBarang = setOrderBarang.findIndex(
            (item) => item.barang_id == value
        );
        if (findIndexOrderBarang !== -1) {
            const getDataBarang = setOrderBarang[findIndexOrderBarang];

            let jumlahDataBarang = parseFloat(getDataBarang.qty_orderbarang);
            const jumlahDataBarangPlus = ++jumlahDataBarang;
            const stokDataBarang = getDataBarang.stok_barang;

            if (jumlahDataBarangPlus < 0) {
                getDataBarang.qty_orderbarang = 0;
            }
            if (jumlahDataBarangPlus > stokDataBarang) {
                getDataBarang.qty_orderbarang = jumlahDataBarang;
                runToast({
                    type: "bg-danger",
                    description: `Barang: ${getDataBarang.nama_barang} melebihi stok barang`,
                });
            }

            getDataBarang.qty_orderbarang = jumlahDataBarangPlus;

            $(
                `input[name="qty_orderbarang"][data-id="${getDataBarang.id}"]`
            ).val(formatNumber(jumlahDataBarangPlus));

            newOrderBarang(getDataBarang.id);

            const getPayload = payloadOrderBarang(getDataBarang.id);
            updateOrderBarang(getPayload);
            return;
        }

        if (value === "") {
            return runToast({
                type: "bg-danger",
                description: "Barang wajib diisi",
                title: "Form Validation",
            });
        }

        const getFindData = jsonGetBarang.find((item) => item.id == value);

        const payload = {
            users_id: jsonUsersId,
            barang_id: value,
            penerimaan_servis_id: jsonPenerimaanServisId,
            qty_orderbarang: 1,
            subtotal_orderbarang: getFindData.hargajual_barang,
        };

        $.ajax({
            url: `${urlRoot}/service/orderBarang`,
            type: "post",
            dataType: "json",
            data: payload,
            success: function (data) {
                renderListBarang(data);
            },
        });
    });

    const updateOrderBarang = (payload) => {
        $.ajax({
            url: `${urlRoot}/service/orderBarang/${payload.id}?_method=put`,
            type: "post",
            dataType: "json",
            data: payload,
            success: function (data) {
                renderListBarang(data);
            },
        });
    };

    const inputOrderBarang = (id) => {
        const qty_orderbarang = $(
            `input[name="qty_orderbarang"][data-id="${id}"]`
        ).val();
        const typediskon_orderbarang = $(
            `select[name="typediskon_orderbarang"][data-id="${id}"]`
        ).val();
        const diskon_orderbarang = $(
            `input[name="diskon_orderbarang"][data-id="${id}"]`
        ).val();

        return {
            qty_orderbarang,
            typediskon_orderbarang,
            diskon_orderbarang,
        };
    };

    const newOrderBarang = (id) => {
        const getInputOrderBarang = inputOrderBarang(id);

        // set by id data
        const getFindIndex = setOrderBarang.findIndex((item) => item.id == id);
        if (getFindIndex !== -1) {
            const dataOrderBarang = setOrderBarang[getFindIndex];
            const jumlahHargaBarang = dataOrderBarang.hargajual_barang;

            dataOrderBarang.id = id;
            dataOrderBarang.qty_orderbarang = removeCommas(
                getInputOrderBarang.qty_orderbarang
            );
            dataOrderBarang.typediskon_orderbarang =
                getInputOrderBarang.typediskon_orderbarang;
            dataOrderBarang.diskon_orderbarang = removeCommas(
                getInputOrderBarang.diskon_orderbarang
            );

            // set sub total
            dataOrderBarang.subtotal_orderbarang =
                parseFloat(removeCommas(getInputOrderBarang.qty_orderbarang)) *
                parseFloat(jumlahHargaBarang);

            if (getInputOrderBarang.typediskon_orderbarang == "fix") {
                dataOrderBarang.subtotal_orderbarang =
                    dataOrderBarang.subtotal_orderbarang -
                    removeCommas(dataOrderBarang.diskon_orderbarang);
            }
            if (getInputOrderBarang.typediskon_orderbarang == "%") {
                const priceDiskon =
                    (dataOrderBarang.subtotal_orderbarang *
                        removeCommas(dataOrderBarang.diskon_orderbarang)) /
                    100;
                dataOrderBarang.subtotal_orderbarang =
                    dataOrderBarang.subtotal_orderbarang - priceDiskon;
            }
        }
    };

    const payloadOrderBarang = (id) => {
        const getFindIndex = setOrderBarang.findIndex((item) => item.id == id);
        let payload;
        if (getFindIndex !== -1) {
            const dataOrderBarang = setOrderBarang[getFindIndex];
            payload = {
                id: dataOrderBarang.id,
                users_id: jsonUsersId,
                barang_id: dataOrderBarang.barang_id,
                penerimaan_servis_id: jsonPenerimaanServisId,
                qty_orderbarang: dataOrderBarang.qty_orderbarang,
                typediskon_orderbarang: dataOrderBarang.typediskon_orderbarang,
                diskon_orderbarang: dataOrderBarang.diskon_orderbarang,
                subtotal_orderbarang: dataOrderBarang.subtotal_orderbarang,
            };
        }
        return payload;
    };

    body.on(
        "input",
        'input[name="qty_orderbarang"]',
        debounce(function () {
            const getValueInput = $(this).val();
            if (getValueInput == "") {
                return;
            }

            const id = $(this).data("id");
            const qtyValue = parseFloat(removeCommas($(this).val()));

            // check awal
            const getFindIndex = setOrderBarang.findIndex(
                (item) => item.id == id
            );
            if (getFindIndex !== -1) {
                const dataOrderBarang = setOrderBarang[getFindIndex];
                if (qtyValue < 0) {
                    $(this).val(0);
                }
                if (qtyValue > dataOrderBarang.stok_barang) {
                    $(this).val(0);
                    runToast({
                        type: "bg-danger",
                        description: `Barang: ${dataOrderBarang.nama_barang} melebihi stok barang`,
                    });
                }
            }

            newOrderBarang(id);

            const value = formatNumber($(this).val());
            $(this).val(value);

            const getPayload = payloadOrderBarang(id);
            updateOrderBarang(getPayload);
        }, 1000)
    );

    body.on("change", 'select[name="typediskon_orderbarang"]', function () {
        const id = $(this).data("id");

        newOrderBarang(id);

        const value = $(this).val();
        if (value == "") {
            $(`input[name="diskon_orderbarang"][data-id="${id}"]`).attr(
                "disabled",
                true
            );
        } else {
            $(`input[name="diskon_orderbarang"][data-id="${id}"]`).attr(
                "disabled",
                false
            );
        }

        const getPayload = payloadOrderBarang(id);
        updateOrderBarang(getPayload);
    });

    body.on(
        "input",
        'input[name="diskon_orderbarang"]',
        debounce(function () {
            const id = $(this).data("id");
            const getInputOrderBarang = inputOrderBarang(id);

            const getValue = parseFloat(removeCommas($(this).val()));
            if (getInputOrderBarang.typediskon_orderbarang == "%") {
                if (getValue < 0) {
                    $(this).val(0);
                }
                if (getValue > 100) {
                    $(this).val(0);
                }
            }

            newOrderBarang(id);

            const value = formatNumber($(this).val());
            $(this).val(value);

            const getPayload = payloadOrderBarang(id);
            updateOrderBarang(getPayload);
        }, 1000)
    );
});
