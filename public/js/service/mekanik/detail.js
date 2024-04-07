// "use strict";
var datatable;
var myModal;

var jsonUsersId = $(".usersId").data("value");
var jsonPenerimaanServisId = $(".penerimaanServisId").data("value");
var jsonGetServis = $(".getServis").data("value");
var jsonGetBarang = $(".getBarang").data("value");
var jsonTipeDiskon = $(".getTipeDiskon").data("value");
var jsonCabangId = $(".cabangId").data("value");
var jsonServiceHistory = [];

var urlRoot = $(".url_root").data("url");
var renderListServis = () => {};
var renderListBarang = () => {};
var setOrderBarang = [];

const viewServiceHistori = (rowData) => {
    $(".output_created_at").html(formatDateFromDb(rowData.created_at));
    $(".status_pservis_label").html(
        `Status Servis (${formatDateFromDb(rowData.updated_at)})`
    );
    $(".output_status_pservis").html(
        capitalizeEachWord(rowData.status_pservis)
    );
    $(".output_name").html(capitalizeEachWord(rowData.users.name));

    let outputService = ``;
    let no = 1;
    rowData.service_history.map((vData) => {
        outputService += `
    <tr>
        <td class="w-25">${no++}</td>
        <td>${formatDateFromDb(vData.created_at)}</td>
        <td>${capitalizeEachWord(vData.status_histori)}</td>
    </tr>
    `;
    });

    $(".loadServiceHistory").html(outputService);
};

const refreshDataArea = () => {
    $.ajax({
        url: `${urlRoot}/service/penerimaanServis/${jsonPenerimaanServisId}`,
        dataType: "json",
        type: "get",
        data: {
            refresh: true,
        },
        success: function (data) {
            const rowData = data.row;

            const statusAllowed = ["bisa diambil"];
            if (statusAllowed.includes(rowData.status_pservis)) {
                getGlobalRefresh = true;
                runGlobalRefresh();
            } else {
                const statusCancel = [
                    "tidak bisa",
                    "cancel",
                    "komplain garansi",
                    "sudah diambil",
                ];

                if (!statusCancel.includes(rowData.status_pservis)) {
                    getGlobalRefresh = false;
                    runGlobalRefresh();
                } else {
                    getGlobalRefresh = true;
                    runGlobalRefresh();
                }
            }
        },
    });
};

const refreshData = () => {
    $.ajax({
        url: `${urlRoot}/service/penerimaanServis/${jsonPenerimaanServisId}`,
        dataType: "json",
        type: "get",
        data: {
            refresh: true,
        },
        success: function (data) {
            jsonUsersId = data.usersId;
            jsonPenerimaanServisId = data.penerimaanServisId;
            jsonGetServis = data.getServis;
            jsonGetBarang = data.barang;
            jsonTipeDiskon = JSON.parse(data.tipeDiskon);
            jsonCabangId = data.cabangId;
            jsonServiceHistory = data.row.service_history;

            let select2HargaServis = [];
            select2HargaServis.push({
                id: "",
                text: "Pilih Harga Servis",
            });
            data.array_harga_servis.map((value, index) => {
                select2HargaServis.push({
                    id: value.id,
                    text: value.label,
                });
            });

            let select2Barang = [];
            select2Barang.push({
                id: "",
                text: "Pilih Barang",
            });
            data.array_barang.map((value, index) => {
                select2Barang.push({
                    id: value.id,
                    text: value.label,
                });
            });

            var selectElementHargaServis = $("select[name='harga_servis_id']");
            selectElementHargaServis.empty();
            $.each(select2HargaServis, function (index, option) {
                selectElementHargaServis.append(
                    new Option(option.text, option.id, false, false)
                );
            });
            selectElementHargaServis.select2("destroy");

            select2Standard({
                parent: ".content-wrapper",
                selector: "select[name='harga_servis_id']",
                data: select2HargaServis,
            });

            var selectElementBarang = $("select[name='barang_id']");
            selectElementBarang.empty();
            $.each(select2Barang, function (index, option) {
                selectElementBarang.append(
                    new Option(option.text, option.id, false, false)
                );
            });
            selectElementBarang.select2("destroy");
            select2Standard({
                parent: ".content-wrapper",
                selector: "select[name='barang_id']",
                data: select2Barang,
            });

            // output servis history
            const rowData = data.row;
            viewServiceHistori(rowData);

            // check handle berkala
            const statusAllowed = ["proses servis", "bisa diambil"];
            if (statusAllowed.includes(rowData.status_pservis)) {
                $(".handle-berkala").removeClass("d-none");
            } else {
                $(".handle-berkala").addClass("d-none");
            }

            // handle output transaksi
            $(".output_totalbiaya_pservis").html(
                formatUang(rowData.totalbiaya_pservis)
            );
            $(".output_hutang_pservis").html(
                formatUang(rowData.hutang_pservis)
            );
            $(".output_total_dppservis").html(
                formatUang(rowData.total_dppservis)
            );

            // handle after status servis
            const getStatus = rowData.status_pservis;
            if (getStatus == "bisa diambil") {
            }
        },
    });
};

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
     <td class="hidden_after_bisa_diambil">
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
    $(".onLoadServis").html(output);
    $(".totalHargaServis").html(formatUang(totalHargaServis));
    refreshData();
};

renderListBarang = (data, isOnlyTotalHarga = false) => {
    let output = ``;
    const { result, totalHargaBarang } = data;
    let no = 1;
    result.map((v) => {
        if (!isOnlyTotalHarga) {
            const checkFindIndex = setOrderBarang.findIndex(
                (item) => item.id === v.id
            );
            if (checkFindIndex == -1) {
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
                        v.diskon_orderbarang == null
                            ? ""
                            : v.diskon_orderbarang,
                    subtotal_orderbarang: v.subtotal_orderbarang,
                });
            }
        }

        if (!isOnlyTotalHarga) {
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
     <td class="hidden_after_bisa_diambil">
         <a href="${urlRoot}/service/orderBarang/${
                v.id
            }?_method=delete" data-id="${v.id}"
             class="btn btn-danger delete-order-barang btn-small"
             title="Delete Order Barang">
             <i class="fa-solid fa-trash"></i>
         </a>
     </td>
 </tr>
 `;
        }

        if (isOnlyTotalHarga) {
            $(`input[name="qty_orderbarang"][data-id="${v.id}" ]`).attr(
                "title",
                `Stok Barang: ${v.barang.stok_barang}`
            );
        }
    });
    if (!isOnlyTotalHarga) {
        $(".loadOrderBarang").html(output);
    }

    $(".totalHargaBarang").html(formatUang(totalHargaBarang));
    refreshData();
};

const runDataPenerimaan = () => {
    $(document).ready(function () {
        select2Standard({
            parent: ".content-wrapper",
            selector: "select[name='harga_servis_id']",
        });
        select2Standard({
            parent: ".content-wrapper",
            selector: "select[name='barang_id']",
        });
        select2Standard({
            parent: ".content-wrapper",
            selector: "select[name='status_pservis']",
        });
        select2Standard({
            parent: ".content-wrapper",
            selector: "select[name='tipeberkala_pservis']",
        });

        refreshData();

        var body = $("body");
        body.off("click", ".detail-customer");
        body.on("click", ".detail-customer", function () {
            showModal({
                url: $(this).data("urlcreate"),
                modalId: $(this).data("typemodal"),
                title: "Detail Kendaraan",
                type: "get",
            });
        });

        body.off("click", ".detail-penerimaan-servis");
        body.on("click", ".detail-penerimaan-servis", function () {
            showModal({
                url: $(this).data("urlcreate"),
                modalId: $(this).data("typemodal"),
                title: "Detail Kendaraan",
                type: "get",
            });
        });

        body.off("click", ".identitas-kendaraan");
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

        body.off("change", 'select[name="harga_servis_id"]');
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
                cabang_id: jsonCabangId,
            };

            $.ajax({
                url: $(".url_order_servis").data("url"),
                type: "post",
                dataType: "json",
                data: payload,
                success: function (data) {
                    renderListServis(data);
                    refreshData();
                },
            });
        });

        body.off("click", ".delete-order-servis");
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

        body.off("click", ".update-users-mekanik");
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

        body.off("change", 'select[name="barang_id"]');
        body.on("change", "select[name='barang_id']", function () {
            const value = $(this).val();
            if (value === "" || value === "-") {
                return runToast({
                    type: "bg-danger",
                    description: "Barang wajib diisi",
                    title: "Form Validation",
                });
            }

            // handle input qty
            const findIndexOrderBarang = setOrderBarang.findIndex(
                (item) => item.barang_id == value
            );
            if (findIndexOrderBarang !== -1) {
                const getDataBarang = setOrderBarang[findIndexOrderBarang];

                let jumlahDataBarang = parseFloat(
                    getDataBarang.qty_orderbarang
                );
                let jumlahDataBarangPlus = ++jumlahDataBarang;
                const stokDataBarang = getDataBarang.stok_barang;

                if (jumlahDataBarangPlus < 0) {
                    jumlahDataBarangPlus = 0;
                    getDataBarang.qty_orderbarang = 0;
                }
                if (jumlahDataBarangPlus > stokDataBarang) {
                    jumlahDataBarangPlus = jumlahDataBarang;
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

                handleDisplayInput();
                return;
            }

            const getFindData = jsonGetBarang.find((item) => item.id == value);

            const payload = {
                users_id: jsonUsersId,
                barang_id: value,
                penerimaan_servis_id: jsonPenerimaanServisId,
                qty_orderbarang: 1,
                subtotal_orderbarang: getFindData.hargajual_barang,
                cabang_id: jsonCabangId,
            };

            $.ajax({
                url: `${urlRoot}/service/orderBarang`,
                type: "post",
                dataType: "json",
                data: payload,
                success: function (data) {
                    renderListBarang(data);
                    refreshData();
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
                    renderListBarang(data, true);
                    refreshData();
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
            const getFindIndex = setOrderBarang.findIndex(
                (item) => item.id == id
            );
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
                    parseFloat(
                        removeCommas(getInputOrderBarang.qty_orderbarang)
                    ) * parseFloat(jumlahHargaBarang);

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
            const getFindIndex = setOrderBarang.findIndex(
                (item) => item.id == id
            );
            let payload;
            if (getFindIndex !== -1) {
                const dataOrderBarang = setOrderBarang[getFindIndex];
                payload = {
                    id: dataOrderBarang.id,
                    users_id: jsonUsersId,
                    barang_id: dataOrderBarang.barang_id,
                    penerimaan_servis_id: jsonPenerimaanServisId,
                    qty_orderbarang: dataOrderBarang.qty_orderbarang,
                    typediskon_orderbarang:
                        dataOrderBarang.typediskon_orderbarang,
                    diskon_orderbarang: dataOrderBarang.diskon_orderbarang,
                    subtotal_orderbarang: dataOrderBarang.subtotal_orderbarang,
                    cabang_id: jsonCabangId,
                };
            }
            return payload;
        };

        const handleDisplayInput = () => {
            setOrderBarang.map((vItem, iItem) => {
                $(`input[name="qty_orderbarang"][data-id="${vItem.id}"]`).val(
                    formatNumber(vItem.qty_orderbarang)
                );
                $(
                    `select[name="typediskon_orderbarang"][data-id="${vItem.id}"]`
                ).val(vItem.typediskon_orderbarang);
                $(
                    `input[name="diskon_orderbarang"][data-id="${vItem.id}"]`
                ).val(formatNumber(vItem.diskon_orderbarang));
                $(`.output_subtotal_orderbarang[data-id="${vItem.id}"]`).html(
                    formatNumber(vItem.subtotal_orderbarang)
                );
            });
        };

        body.off("input", 'input[name="qty_orderbarang"]');
        body.on(
            "input",
            'input[name="qty_orderbarang"]',
            debounce(function () {
                const id = $(this).data("id");
                const getValueInput = $(
                    `input[name="qty_orderbarang"][data-id="${id}"]`
                ).val();
                if (getValueInput == "") {
                    return;
                }

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

                // update display input
                handleDisplayInput();
            }, 500)
        );

        body.off("change", 'select[name="typediskon_orderbarang"]');
        body.on("change", 'select[name="typediskon_orderbarang"]', function () {
            const id = $(this).data("id");
            const getValueInput = $(
                `input[name="qty_orderbarang"][data-id="${id}"]`
            ).val();
            if (getValueInput == "") {
                return;
            }

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

            handleDisplayInput();
        });

        body.off("input", 'input[name="diskon_orderbarang"]');
        body.on(
            "input",
            'input[name="diskon_orderbarang"]',
            debounce(function () {
                const id = $(this).data("id");
                const getValueInput = $(
                    `input[name="qty_orderbarang"][data-id="${id}"]`
                ).val();
                if (getValueInput == "") {
                    return;
                }

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

                handleDisplayInput();
            }, 500)
        );

        body.off("click", ".delete-order-barang");
        body.on("click", ".delete-order-barang", function (e) {
            e.preventDefault();

            const id = $(this).data("id");
            const indexOrderBarang = setOrderBarang.findIndex(
                (item) => item.id == id
            );
            if (indexOrderBarang !== -1) {
                setOrderBarang.splice(indexOrderBarang, 1);
            }

            basicDeleteConfirmDatatable({
                urlDelete: $(this).attr("href"),
                data: {
                    penerimaan_servis_id: jsonPenerimaanServisId,
                },
                text: "Apakah anda yakin ingin menghapus item ini?",
                dataFunction: renderListBarang,
            });
        });

        const payloadSubmit = () => {
            const getValue = (name) => $(`[name="${name}"]`).val() || "";

            const payload = {
                status_pservis: getValue("status_pservis"),
                nilaiberkala_pservis: getValue("nilaiberkala_pservis"),
                tipeberkala_pservis: getValue("tipeberkala_pservis"),
                catatanteknisi_pservis: getValue("catatanteknisi_pservis"),
                kondisiservis_pservis: getValue("kondisiservis_pservis"),
                pesanwa_pservis: getValue("pesanwa_pservis"),
            };

            return payload;
        };

        body.off("click", ".btn-submit-data");
        body.on("click", ".btn-submit-data", function (e) {
            e.preventDefault();
            const payload = payloadSubmit();

            const lastStatus = jsonServiceHistory.length - 1;
            const getLastStatus = jsonServiceHistory[lastStatus].status_histori;
            if (getLastStatus == payload.status_pservis) {
                return runToast({
                    type: "bg-danger",
                    title: "Form Validation",
                    description:
                        "Status servis anda terakhir sama dengan status servis anda yang baru",
                });
            }

            const getValueStatus = $('select[name="status_pservis"]').val();
            const statusAllowed = ["bisa diambil"];
            const fieldStatusAmbil =
                (payload.nilaiberkala_pservis == "" &&
                    payload.tipeberkala_pservis != "") ||
                (payload.nilaiberkala_pservis != "" &&
                    payload.tipeberkala_pservis == "") ||
                (payload.nilaiberkala_pservis == "" &&
                    payload.tipeberkala_pservis == "");

            if (fieldStatusAmbil && statusAllowed.includes(getValueStatus)) {
                return runToast({
                    type: "bg-danger",
                    title: "Form Validation",
                    description:
                        "Wajib mengisi nilai berkala, dan wajib mengisi tipe servis berkala",
                });
            }

            const submitAjaxData = () => {
                $.ajax({
                    type: "post",
                    url: `${urlRoot}/service/penerimaanServis/${jsonPenerimaanServisId}?_method=put`,
                    data: payload,
                    dataType: "json",
                    beforeSend: function () {
                        clearError422();
                        $(".btn-submit-data").attr("disabled", true);
                        $(".btn-submit-data").html(disableButton);
                    },
                    success: function (data) {
                        runToast({
                            title: "Successfully",
                            description: data,
                            type: "bg-success",
                        });
                        refreshData();
                        refreshDataArea();
                    },
                    error: function (jqXHR, exception) {
                        $(".btn-submit-data").attr("disabled", false);
                        $(".btn-submit-data").html(enableButton);
                        if (jqXHR.status === 422) {
                            showErrors422(jqXHR);
                        }
                    },
                    complete: function () {
                        $(".btn-submit-data").attr("disabled", false);
                        $(".btn-submit-data").html(enableButton);
                    },
                });
            };

            let booleanStatus = false;
            if (getValueStatus == "bisa diambil") {
                Swal.fire({
                    title: "Konfirmasi",
                    html: `Apakah anda yakin ingin konfirmasi bahwa servis sudah bisa diambil ? <br /><br /> 
                <strong> Proses ini tidak dapat diedit kembali, 
                jika terjadi kesalahan maka wajib menghapus dan buat dari awal</strong>`,
                    icon: "warning",
                    dangerMode: true,
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.isConfirmed) {
                        booleanStatus = true;
                        submitAjaxData();
                    }
                });
            } else {
                booleanStatus = true;
            }

            if (booleanStatus) {
                submitAjaxData();
            }
        });

        const renderPrintKasir = () => {
            var output = "";
            $.ajax({
                url: `${urlRoot}/service/print/kendaraan/servis`,
                dataType: "json",
                type: "get",
                data: {
                    penerimaan_servis_id: jsonPenerimaanServisId,
                },
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

        body.off("click", ".btn-print-data");
        body.on("click", ".btn-print-data", function (e) {
            e.preventDefault();
            const output = renderPrintKasir();
            printOutput(output);
        });
    });
};
