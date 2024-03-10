// "use strict";
var datatable;
var jsonString = $(".json_customer").data("json");
var jsonStringBarang = $(".json_barang").data("json");
var jsonTipeDiskon = $(".json_tipe_diskon").data("json");
var jsonKategoriPembayaran = $(".json_kategori_pembayaran").data("json");
var jsonArrayKategoriPembayaran = $(".json_array_kategori_pembayaran").data(
    "json"
);
var jsonSubPembayaran = $(".json_sub_pembayaran").data("json");
var jsonArraySubPembayaran = $(".json_array_sub_pembayaran").data("json");
var jsonDataUser = $(".json_data_user").data("json");
var jsonDefaultUser = $(".json_default_user").data("json");

var body = $("body");
var orderItems = [];
var metodePembayaran = [];
var totalHargaItems = 0;

$(document).ready(function () {
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='barang_id']",
    });

    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='customer_id']",
    });

    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='kategori_pembayaran_id']",
    });

    const renderViewKasir = () => {
        var output = ``;
        orderItems.map((value, index) => {
            output += `
            <tr>
                <td>${value.nama_barang} (${value.satuan.nama_satuan})</td>
                <td>
                    <input name="qty" type="text" class="form-control"  
                    title="Stock: ${value.stok_barang} barang" 
                    value="${value.qty}" data-id="${value.id}" />
                </td>
                <td>
                    <span class="hargajual_barang" data-id="${value.id}">
                        ${number_format(value.hargajual_barang, 0, ".", ",")}
                    </span>
                </td>
                <td>
                    <select name="type_discount" class="form-select" data-id="${
                        value.id
                    }">
                        <option value="" selected>Tipe Diskon</option>`;

            Object.keys(jsonTipeDiskon).map((v, i) => {
                output += `
                <option value="${v}" ${
                    value.tipeDiskon == v ? "selected" : ""
                }>${jsonTipeDiskon[v]}</option>
                `;
            });

            output += `
                    </select>
                </td>
                <td>
                    <input
                    name="jumlah_diskon"
                    class="jumlahDiskon form-control" 
                    data-id="${value.id}" 
                    value="${value.jumlahDiskon}"
                    disabled />
                </td>
                <td>
                    <span class="totalHarga" data-id="${value.id}">
                        ${number_format(value.totalHarga, 0, ".", ",")}
                    </span>
                </td>
                <td>
                    <button class="btn btn-delete" title="Hapus item" data-id="${
                        value.id
                    }">
                        <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i
                    </button>
                </td>
            </tr>
            `;
        });
        $("#orderBarang").html(output);
        $("#total_harga_all").html(number_format(totalHargaItems, 0, ".", ","));
    };

    const domViewKasir = (orderItemsValue) => {
        $(`input[name="qty"][data-id="${orderItemsValue.id}"]`).val(
            formatNumber(orderItemsValue.qty)
        );
        $(`select[name="type_discount"][data-id="${orderItemsValue.id}"]`).val(
            orderItemsValue.tipeDiskon
        );
        $(`.jumlahDiskon[data-id="${orderItemsValue.id}"]`).val(
            formatNumber(orderItemsValue.jumlahDiskon)
        );
        $(`.totalHarga[data-id="${orderItemsValue.id}"]`).html(
            number_format(orderItemsValue.totalHarga, 0, ".", ",")
        );

        totalHargaItems = orderItems.reduce(function (sum, current) {
            return sum + current.totalHarga;
        }, 0);
        $("#total_harga_all").html(number_format(totalHargaItems, 0, ".", ","));
    };

    const changeHandleInput = (id) => {
        const qty = removeCommas($(`input[name="qty"][data-id="${id}"]`).val());
        const searchOrderItems = orderItems.findIndex((item) => item.id == id);
        const getTypeDiscount = $(
            `select[name="type_discount"][data-id="${id}"] option:selected`
        ).val();
        const getJumlahDiskon = $(`.jumlahDiskon[data-id="${id}"]`).val();
        if (searchOrderItems !== -1) {
            orderItems[searchOrderItems].qty = qty;
            if (orderItems[searchOrderItems].stok_barang < qty) {
                orderItems[searchOrderItems].qty = "1";
            }
            orderItems[searchOrderItems].totalHarga =
                orderItems[searchOrderItems].qty *
                orderItems[searchOrderItems].hargajual_barang;
            orderItems[searchOrderItems].tipeDiskon = getTypeDiscount;
            orderItems[searchOrderItems].jumlahDiskon =
                removeCommas(getJumlahDiskon);

            if (
                orderItems[searchOrderItems].tipeDiskon !== "" &&
                orderItems[searchOrderItems].tipeDiskon !== null
            ) {
                $(`.jumlahDiskon[data-id="${id}"]`).attr("disabled", false);
                if (orderItems[searchOrderItems].tipeDiskon == "fix") {
                    orderItems[searchOrderItems].totalHarga =
                        orderItems[searchOrderItems].totalHarga -
                        removeCommas(orderItems[searchOrderItems].jumlahDiskon);
                }
                if (orderItems[searchOrderItems].tipeDiskon == "%") {
                    const priceDiskon =
                        (orderItems[searchOrderItems].totalHarga *
                            removeCommas(
                                orderItems[searchOrderItems].jumlahDiskon
                            )) /
                        100;
                    orderItems[searchOrderItems].totalHarga =
                        orderItems[searchOrderItems].totalHarga - priceDiskon;
                }

                if (orderItems[searchOrderItems].totalHarga < 0) {
                    orderItems[searchOrderItems].totalHarga =
                        orderItems[searchOrderItems].qty *
                        orderItems[searchOrderItems].hargajual_barang;
                    orderItems[searchOrderItems].jumlahDiskon = "";
                }
            } else {
                orderItems[searchOrderItems].jumlahDiskon = "";
                $(`.jumlahDiskon[data-id="${id}"]`).attr("disabled", true);
            }

            domViewKasir(orderItems[searchOrderItems]);
        }
    };

    const viewMetodePembayaran = () => {
        let output = "";
        metodePembayaran.map((value, index) => {
            if (
                value.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() ===
                "langsung"
            ) {
                output += `
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select data-index="${index}" name="kategori_pembayaran_id_mp" class="form-control">
                                <option value="">-- Kategori Pembayaran --</option>`;

                value.kategori_pembayaran.map((v, i) => {
                    output += `
                        <option value="${v.id}" ${
                        v.id === value.kategori_pembayaran_selected.id
                            ? "selected"
                            : ""
                    }>${v.nama_kpembayaran}</option>
                    `;
                });

                output += `
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-delete-pembayaran" title="Hapus item" data-index="${index}">
                            <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select data-index="${index}" name="sub_pembayaran_id_mp" class="form-control">
                                <option value="">-- Sub Pembayaran --</option>`;

                value.sub_pembayaran.map((v, i) => {
                    output += `
                    <option value="${v.id}" ${
                        v.id ==
                        (value.sub_pembayaran_selected &&
                            value.sub_pembayaran_selected.id)
                            ? "selected"
                            : ""
                    }>${v.nama_spembayaran}</option>
                    `;
                });

                output += `
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Bayar</label>
                            <input class="form-control" type="text" name="bayar" data-index="${index}"
                                placeholder="Masukan nominal pembayaran..." 
                                value="${number_format(
                                    value.bayar,
                                    0,
                                    ".",
                                    ","
                                )}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Dibayar Oleh</label>
                            <input class="form-control" type="text" name="dibayar_oleh" data-index="${index}"
                                placeholder="Dibayarkan oleh..." value="${
                                    value.dibayarkan_oleh !== undefined
                                        ? value.dibayarkan_oleh
                                        : ""
                                }">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Akun</label>
                            <select name="akun" class="form-control" 
                            data-index="${index}">
                                <option value="">Akun Kasir</option>`;

                value.user.map((v, i) => {
                    output += `
                    <option value="${v.id}" ${
                        v.id === (value.user_selected && value.user_selected.id)
                            ? "selected"
                            : ""
                    }>${v.name}</option>
                    `;
                });

                output += `
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Kembalian</label>
                            <input class="form-control" type="text" name="kembalian" data-index="${index}" placeholder="Kembalian..." value="${number_format(
                    value.kembalian,
                    0,
                    ".",
                    ","
                )}" disabled>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Hutang</label>
                            <input class="form-control" type="text" name="hutang" data-index="${index}" placeholder="Hutang..." value="${number_format(
                    value.hutang,
                    0,
                    ".",
                    ","
                )}" disabled>
                        </div>
                    </div>
                </div>
                <hr style="color: #1381f0;" />
                `;
            } else {
                output += `
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <select 
                            data-index="${index}"
                            name="kategori_pembayaran_id_mp" id="" class="form-control">
                                <option value="">-- Kategori Pembayaran --</option>`;
                value.kategori_pembayaran.map((v, i) => {
                    output += `
                                        <option value="${v.id}" ${
                        v.id === value.kategori_pembayaran_selected.id
                            ? "selected"
                            : ""
                    }>${v.nama_kpembayaran}</option>
                                    `;
                });

                output += `
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <button class="btn btn-delete-pembayaran" title="Hapus item" data-index="${index}">
                            <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i>
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <select name="sub_pembayaran_id_mp" data-index="${index}"
                            class="form-control">
                                <option value="">-- Sub Pembayaran --</option>`;

                value.sub_pembayaran.map((v, i) => {
                    output += `
                                    <option value="${v.id}" ${
                        v.id ==
                        (value.sub_pembayaran_selected &&
                            value.sub_pembayaran_selected.id)
                            ? "selected"
                            : ""
                    }>${v.nama_spembayaran}</option>
                                    `;
                });

                output += `
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Nomor Kartu</label>
                            <input class="form-control" type="text" name="nomor_kartu" data-index="${index}"
                                placeholder="Masukan Nomor Kartu..." value="${
                                    value.nomor_kartu !== undefined
                                        ? value.nomor_kartu
                                        : ""
                                }">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Nama Pemilik Kartu</label>
                            <input class="form-control" type="text" name="nama_pemilik_kartu" 
                            data-index="${index}"
                                placeholder="Pemilik Kartu..." value="${
                                    value.nama_pemilik_kartu !== undefined
                                        ? value.nama_pemilik_kartu
                                        : ""
                                }">
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Akun</label>
                            <select 
                            name="akun" 
                            class="form-control" 
                            data-index="${index}">
                                <option value="">Akun Kasir</option>`;

                value.user.map((v, i) => {
                    output += `
                                    <option value="${v.id}" ${
                        v.id === (value.user_selected && value.user_selected.id)
                            ? "selected"
                            : ""
                    }>${v.name}</option>
                                    `;
                });

                output += `
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Bayar</label>
                            <input 
                            class="form-control" 
                            type="text" 
                            name="bayar" 
                            data-index="${index}"
                            placeholder="Masukan nominal pembayaran..." 
                            value="${number_format(value.bayar, 0, ".", ",")}">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label for="">Hutang</label>
                            <input class="form-control" type="text" name="hutang" data-index="${index}" placeholder="Hutang..." 
                            value="${number_format(
                                value.hutang,
                                0,
                                ".",
                                ","
                            )}" disabled>
                        </div>
                    </div>
                </div>
                <hr style="color: #1381f0;" />
                `;
            }
        });
        return output;
    };

    const handleAnotherMethodLangsung = (index) => {
        const getMetodePembayaran = metodePembayaran[index];
        if (
            getMetodePembayaran.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() !==
            "langsung"
        ) {
            if (index === 0) {
                if (parseFloat(getMetodePembayaran.bayar) > totalHargaItems) {
                    metodePembayaran[index].bayar = totalHargaItems;
                }
            }
            if (index > 0) {
                if (
                    parseFloat(getMetodePembayaran.bayar) >
                    parseFloat(metodePembayaran[index - 1].hutang)
                ) {
                    metodePembayaran[index].bayar =
                        metodePembayaran[index - 1].hutang;
                }
            }
        }
    };

    const handleDisplayInput = () => {
        metodePembayaran.map((value, index) => {
            $(
                `select[name="kategori_pembayaran_id_mp"][data-index="${index}"]`
            ).val(value.kategori_pembayaran_selected.id);
            $(`select[name="sub_pembayaran_id_mp"][data-index="${index}"]`).val(
                value.sub_pembayaran_selected &&
                    value.sub_pembayaran_selected.id
            );
            $(`input[name="bayar"][data-index="${index}"]`).val(
                formatNumber(value.bayar)
            );
            $(`input[name="dibayar_oleh"][data-index="${index}"]`).val(
                value.dibayarkan_oleh
            );
            $(`select[name="akun"][data-index="${index}"]`).val(
                value.user_selected && value.user_selected.id
            );
            $(`input[name="kembalian"][data-index="${index}"]`).val(
                formatNumber(value.kembalian)
            );
            $(`input[name="hutang"][data-index="${index}"]`).val(
                formatNumber(value.hutang)
            );
            $(`input[name="nomor_kartu"][data-index="${index}"]`).val(
                value.nomor_kartu
            );
            $(`input[name="nama_pemilik_kartu"][data-index="${index}"]`).val(
                value.nama_pemilik_kartu
            );
        });
    };

    const handeMetodePembayaran = (index) => {
        const kategori_pembayaran_id = $(
            `select[name="kategori_pembayaran_id_mp"][data-index="${index}"]`
        ).val();
        const sub_pembayaran_id = $(
            `select[name="sub_pembayaran_id_mp"][data-index="${index}"]`
        ).val();
        const users_id = $(`select[name="akun"][data-index="${index}"]`).val();
        let bayar = $(`input[name="bayar"][data-index="${index}"]`).val();
        bayar = removeCommas(bayar);
        let hutang = $(`input[name="hutang"][data-index="${index}"]`).val();
        hutang = removeCommas(hutang);
        if (index === 0) {
            hutang = totalHargaItems;
        }
        if (index > 0) {
            const beforeData = index - 1;
            const getBeforeData = metodePembayaran[beforeData];
            hutang = getBeforeData.hutang;
        }
        let kembalian = $(
            `input[name="kembalian"][data-index="${index}"]`
        ).val();
        kembalian = removeCommas(kembalian);
        const dibayar_oleh = $(
            `input[name="dibayar_oleh"][data-index="${index}"]`
        ).val();
        const nomor_kartu = $(
            `input[name="nomor_kartu"][data-index="${index}"]`
        ).val();
        const nama_pemilik_kartu = $(
            `input[name="nama_pemilik_kartu"][data-index="${index}"]`
        ).val();

        const transaction = bayar - hutang;
        if (transaction < 0) {
            hutang = Math.abs(transaction);
            kembalian = 0;
        } else {
            hutang = 0;
            kembalian = transaction;
        }
        let getKategoriPembayaran = metodePembayaran[index].kategori_pembayaran;
        getKategoriPembayaran = getKategoriPembayaran.find(
            (item) => item.id == kategori_pembayaran_id
        );
        let getSubPembayaran = metodePembayaran[index].sub_pembayaran;
        getSubPembayaran = getSubPembayaran.find(
            (item) => item.id == sub_pembayaran_id
        );
        let getUsers = metodePembayaran[index].user;
        getUsers = getUsers.find((item) => item.id == users_id);

        metodePembayaran[index].kategori_pembayaran_selected =
            getKategoriPembayaran;
        metodePembayaran[index].sub_pembayaran_selected = getSubPembayaran;
        metodePembayaran[index].bayar = bayar;
        metodePembayaran[index].dibayarkan_oleh = dibayar_oleh;
        metodePembayaran[index].user_selected = getUsers;
        metodePembayaran[index].kembalian = kembalian;
        metodePembayaran[index].hutang = hutang;
        metodePembayaran[index].nomor_kartu = nomor_kartu;
        metodePembayaran[index].nama_pemilik_kartu = nama_pemilik_kartu;
    };

    const handleManageHutang = () => {
        metodePembayaran.map((value, index) => {
            if (index === 0) {
                const getData = metodePembayaran[index];
                const bayar = getData.bayar;
                let hutang = totalHargaItems;

                const transaction = bayar - hutang;
                if (transaction < 0) {
                    hutang = Math.abs(transaction);
                    kembalian = 0;
                } else {
                    hutang = 0;
                    kembalian = transaction;
                }

                metodePembayaran[index].bayar = bayar;
                metodePembayaran[index].hutang = hutang;
                metodePembayaran[index].kembalian = kembalian;
            }

            if (index > 0) {
                const calcHutang = () => {
                    const dataNow = metodePembayaran[index];
                    const dataBefore = metodePembayaran[index - 1];

                    if (dataNow !== undefined) {
                        const bayar = dataNow.bayar;
                        let hutang = dataBefore.hutang;

                        const transaction = bayar - hutang;
                        if (transaction < 0) {
                            hutang = Math.abs(transaction);
                            kembalian = 0;
                        } else {
                            hutang = 0;
                            kembalian = transaction;
                        }

                        metodePembayaran[index].bayar = bayar;
                        metodePembayaran[index].hutang = hutang;
                        metodePembayaran[index].kembalian = kembalian;
                    }
                };

                calcHutang();
            }
        });
    };

    const handleButtonBayar = () => {
        let buttonDisabled = false;
        metodePembayaran.map((value, index) => {
            if (
                value.kategori_pembayaran_selected.nama_kpembayaran
                    .toLowerCase !== "langsung"
            ) {
                if (
                    value.kategori_pembayaran_selected === undefined ||
                    value.sub_pembayaran_selected === undefined ||
                    value.bayar === "" ||
                    value.user_selected === undefined ||
                    value.nama_pemilik_kartu === "" ||
                    value.nomor_kartu === ""
                ) {
                    buttonDisabled = true;
                } else {
                    buttonDisabled = false;
                }
            } else {
                if (
                    value.kategori_pembayaran_selected === undefined ||
                    value.sub_pembayaran_selected === undefined ||
                    value.bayar === "" ||
                    value.user_selected === undefined ||
                    value.dibayarkan_oleh === ""
                ) {
                    buttonDisabled = true;
                } else {
                    buttonDisabled = false;
                }
            }
        });

        $(".btn-bayar").attr("disabled", buttonDisabled);
    };

    body.on("change", 'select[name="customer_id"]', function (e) {
        const value = $(this).val();
        if (value !== "" && value !== null) {
            const searchCustomer = jsonString.find((item) => item.id == value);
            $("#load_customer_id").html(`
        <table class="w-100">
            <thead>
                <tr>
                    <th class="text-primary fw-bold">Nama Customer</th>
                    <th class="text-primary fw-bold">No. HP</th>
                    <th class="text-primary fw-bold">Email</th>
                    <th class="text-primary fw-bold">Alamat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>${searchCustomer.nama_customer}</td>
                    <td>${searchCustomer.nowa_customer}</td>
                    <td>${searchCustomer.email_customer}</td>
                    <td>${searchCustomer.alamat_customer}</td>
                </tr>
            </tbody>
        </table>
        `);
        } else {
            $("#load_customer_id").html("");
        }
    });

    body.on("change", 'select[name="barang_id"]', function (e) {
        const value = $(this).val();
        if (value !== "" && value !== null) {
            const getItems = jsonStringBarang.find((item) => item.id == value);

            const searchOrderItems = orderItems.findIndex(
                (item) => item.id == value
            );
            if (searchOrderItems === -1) {
                const mergePayload = {
                    ...getItems,
                    qty: 0,
                    tipeDiskon: "",
                    jumlahDiskon: 0,
                    totalHarga: 0,
                };
                orderItems.push(mergePayload);
            } else {
                orderItems[searchOrderItems].qty++;
                orderItems[searchOrderItems].totalHarga =
                    orderItems[searchOrderItems].qty *
                    orderItems[searchOrderItems].hargajual_barang;
            }

            totalHargaItems = orderItems.reduce(function (sum, current) {
                return sum + current.totalHarga;
            }, 0);

            renderViewKasir();
        }
    });

    body.on("input", 'input[name="qty"]', function () {
        const id = $(this).data("id");
        changeHandleInput(id);
    });
    body.on("change", 'select[name="type_discount"]', function () {
        const id = $(this).data("id");
        changeHandleInput(id);
    });
    body.on("input", 'input[name="jumlah_diskon"]', function () {
        const id = $(this).data("id");
        changeHandleInput(id);
    });

    body.on("click", ".btn-delete", function (e) {
        e.preventDefault();
        const id = $(this).data("id");
        const searchOrderItems = orderItems.findIndex((item) => item.id == id);
        if (searchOrderItems !== -1) {
            orderItems.splice(searchOrderItems, 1);
            totalHargaItems = orderItems.reduce(function (sum, current) {
                return sum + current.totalHarga;
            }, 0);
            renderViewKasir();
        }
    });

    body.on("click", ".btn-add-pembayaran", function (e) {
        e.preventDefault();
        const value = $(
            'select[name="kategori_pembayaran_id"] option:selected'
        ).val();

        const findKategoriPembayaran = jsonKategoriPembayaran.findIndex(
            (item) => item.id == value
        );
        let dataMetodePembayaran = {};
        if (findKategoriPembayaran !== -1) {
            const getKategoriPembayaran =
                jsonKategoriPembayaran[findKategoriPembayaran];
            const getSubPembayaran = jsonSubPembayaran.filter(
                (item) =>
                    item.kategori_pembayaran_id == getKategoriPembayaran.id
            );
            const getDefaultUser = jsonDataUser.findIndex(
                (item) => item.id == jsonDefaultUser
            );
            // user
            let defaultUser = {};
            if (getDefaultUser !== -1) {
                defaultUser = jsonDataUser[getDefaultUser];
            }

            // customer
            const valueCustomer = $(
                'select[name="customer_id"] option:selected'
            ).val();
            const getCustomer = jsonString.find(
                (item) => item.id == valueCustomer
            );

            dataMetodePembayaran.kategori_pembayaran = jsonKategoriPembayaran;
            dataMetodePembayaran.kategori_pembayaran_selected =
                getKategoriPembayaran;
            dataMetodePembayaran.sub_pembayaran = getSubPembayaran;
            dataMetodePembayaran.sub_pembayaran_selected = {};
            dataMetodePembayaran.user = jsonDataUser;
            dataMetodePembayaran.user_selected = defaultUser;
            dataMetodePembayaran.customer = getCustomer;
            dataMetodePembayaran.bayar = 0;
            dataMetodePembayaran.dibayarkan_oleh =
                getCustomer && getCustomer.nama_customer;
            dataMetodePembayaran.kembalian = 0;
            dataMetodePembayaran.hutang =
                metodePembayaran.length == 0 ? totalHargaItems : 0;
            dataMetodePembayaran.nomor_kartu = "";
            dataMetodePembayaran.nama_pemilik_kartu = "";
            metodePembayaran.push(dataMetodePembayaran);
        }

        handleManageHutang();
        handleButtonBayar();
        const output = viewMetodePembayaran();
        $("#output_metode_pembayaran").html(output);
    });

    body.on("click", ".btn-delete-pembayaran", function (e) {
        e.preventDefault();
        const index = $(this).data("index");
        metodePembayaran.splice(index, 1);

        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
        const output = viewMetodePembayaran();
        $("#output_metode_pembayaran").html(output);
    });

    body.on("input", 'input[name="bayar"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung(index);
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("change", 'select[name="kategori_pembayaran_id_mp"]', function () {
        const index = $(this).data("index");
        const value = $(this).val();
        if (value !== null && value !== "") {
            handeMetodePembayaran(index);
            handleAnotherMethodLangsung(index);
            handleManageHutang();
            handleDisplayInput();
            handleButtonBayar();

            const output = viewMetodePembayaran();
            $("#output_metode_pembayaran").html(output);
        }
    });

    body.on("change", 'select[name="sub_pembayaran_id_mp"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung(index);
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("input", 'input[name="nomor_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung(index);
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("input", 'input[name="nama_pemilik_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung(index);
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("change", 'select[name="akun"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung(index);
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("input", 'input[name="dibayar_oleh"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung(index);
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });
});
