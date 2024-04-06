// "use strict";
var datatable;
var urlRoot = $(".url_root").data("url");

var jsonString = $(".json_supplier").data("json");
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
var jsonCabangId = $(".json_cabang_id").data("json");
var jsonNoInvoice = $(".json_no_invoice").data("json");

var body = $("body");
var orderItems = [];
var metodePembayaran = [];
var totalHargaItems = 0;
var supplierId = "";

$(document).ready(function () {
    select2Server({
        selector: "select[name=barang_id]",
        parent: ".content-wrapper",
        routing: `${urlRoot}/select/barang`,
        passData: {
            status_barang: "dijual, dijual & untuk servis",
        },
    });

    select2Server({
        selector: "select[name=supplier_id]",
        parent: ".content-wrapper",
        routing: `${urlRoot}/select/supplier`,
        passData: {},
    });

    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='kategori_pembayaran_id']",
    });

    const refreshDataSet = () => {
        $.ajax({
            url: $(".url_purchase_kasir").data("url"),
            type: "get",
            dataType: "json",
            success: function (data) {
                jsonString = JSON.parse(data.dataSupplier);
                jsonStringBarang = JSON.parse(data.dataBarang);
                jsonTipeDiskon = JSON.parse(data.dataTipeDiskon);
                jsonKategoriPembayaran = JSON.parse(data.kategoriPembayaran);
                jsonArrayKategoriPembayaran = JSON.parse(
                    data.array_kategori_pembayaran
                );
                jsonSubPembayaran = JSON.parse(data.subPembayaran);
                jsonArraySubPembayaran = JSON.parse(data.array_sub_pembayaran);
                jsonDataUser = JSON.parse(data.dataUser);
                jsonDefaultUser = data.defaultUser;
                jsonCabangId = data.cabangId;
                jsonNoInvoice = data.noInvoice;

                // refresh select 2 barang & supplier
                let select2KategoriPembayaran = [];
                select2KategoriPembayaran.push({
                    id: "",
                    text: "Pilih Kategori Pembayaran",
                });
                JSON.parse(data.array_kategori_pembayaran).map(
                    (value, index) => {
                        select2KategoriPembayaran.push({
                            id: value.id,
                            text: value.label,
                        });
                    }
                );

                var selectElementKategoriPembayaran = $(
                    "select[name='kategori_pembayaran_id']"
                );
                selectElementKategoriPembayaran.empty();
                $.each(select2KategoriPembayaran, function (index, option) {
                    selectElementKategoriPembayaran.append(
                        new Option(option.text, option.id, false, false)
                    );
                });
                selectElementKategoriPembayaran.select2("destroy");
                select2Standard({
                    parent: ".content-wrapper",
                    selector: "select[name='kategori_pembayaran_id']",
                    data: select2KategoriPembayaran,
                });
            },
        });
    };

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
        $(".orderBarang").html(output);
        $(".total_harga_all").html(number_format(totalHargaItems, 0, ".", ","));
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
        $(".total_harga_all").html(number_format(totalHargaItems, 0, ".", ","));
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

    const handleAnotherMethodLangsung = () => {
        metodePembayaran.map((v, index) => {
            const getMetodePembayaran = metodePembayaran[index];
            if (
                getMetodePembayaran.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() !==
                "langsung"
            ) {
                if (index === 0) {
                    if (
                        parseFloat(getMetodePembayaran.bayar) > totalHargaItems
                    ) {
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
        });
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
        let buttonDisabledTidakLangsung = false;
        let buttonDisabledLangsung = false;
        let buttonDisabled;

        metodePembayaran.map((value, index) => {
            if (
                value.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() !==
                "langsung"
            ) {
                if (
                    value.kategori_pembayaran_selected === undefined ||
                    value.sub_pembayaran_selected === undefined ||
                    value.bayar === "" ||
                    value.user_selected === undefined ||
                    value.nama_pemilik_kartu === "" ||
                    value.nomor_kartu === "" ||
                    orderItems.length == 0 ||
                    totalHargaItems == 0
                ) {
                    buttonDisabledTidakLangsung = true;
                } else {
                    buttonDisabledTidakLangsung = false;
                }
            } else {
                if (
                    value.kategori_pembayaran_selected === undefined ||
                    value.sub_pembayaran_selected === undefined ||
                    value.bayar === "" ||
                    value.user_selected === undefined ||
                    value.dibayarkan_oleh === "" ||
                    orderItems.length == 0 ||
                    totalHargaItems == 0
                ) {
                    buttonDisabledLangsung = true;
                } else {
                    buttonDisabledLangsung = false;
                }
            }
        });
        buttonDisabled = buttonDisabledTidakLangsung || buttonDisabledLangsung;
        $(".btn-bayar").attr("disabled", buttonDisabled);
    };

    const handleSubPembayaran = (index) => {
        const value = $(
            `select[name="kategori_pembayaran_id_mp"][data-index="${index}"] option:selected`
        ).val();
        const findKategoriPembayaran = jsonKategoriPembayaran.findIndex(
            (item) => item.id == value
        );
        if (findKategoriPembayaran !== -1) {
            const getKategoriPembayaran =
                jsonKategoriPembayaran[findKategoriPembayaran];
            const getSubPembayaran = jsonSubPembayaran.filter(
                (item) =>
                    item.kategori_pembayaran_id == getKategoriPembayaran.id
            );
            metodePembayaran[index].sub_pembayaran = getSubPembayaran;
        }
    };

    const resetData = () => {
        orderItems = [];
        metodePembayaran = [];
        totalHargaItems = 0;
        supplierId = "";
        $(".load_supplier_id").html("");
        $(".orderBarang").html("");
        $(".output_metode_pembayaran").html("");
        $(".total_harga_all").html("0");
        handleButtonBayar();
    };

    const printOutput = (output) => {
        var printWindow = window.open("", "_blank");
        printWindow.document.write(output);
        printWindow.document.close();
        printWindow.print();

        printWindow.addEventListener("afterprint", function () {
            const isEdit = $(".isEdit").data("value");
            if (isEdit) {
                window.location.href = $(".url_simpan_kasir").data("url");
            }
        });

        // Menambahkan event listener untuk menangkap saat jendela print ditutup
        printWindow.onunload = function () {
            const isEdit = $(".isEdit").data("value");
            if (isEdit) {
                window.location.href = $(".url_simpan_kasir").data("url");
            }
        };
        printWindow.close();
    };

    const renderEditData = () => {
        const isEdit = $(".isEdit").data("value");
        if (isEdit == true) {
            $.ajax({
                url: $(".url_purchase_kasir").data("url"),
                type: "get",
                dataType: "json",
                success: function (data) {
                    const pembelian = data.dataPembelian;

                    // render supplier
                    renderSupplier(pembelian.supplier_id);

                    // render pembelian product
                    pembelian.pembelian_product.map((value, index) => {
                        renderBarang(value.barang_id);

                        orderItems[index].qty = value.jumlah_pembelianproduct;

                        orderItems[index].tipeDiskon =
                            value.typediskon_pembelianproduct;

                        orderItems[index].jumlahDiskon =
                            value.diskon_pembelianproduct;

                        orderItems[index].totalHarga =
                            value.subtotal_pembelianproduct;
                    });

                    totalHargaItems = orderItems.reduce(function (
                        sum,
                        current
                    ) {
                        return sum + current.totalHarga;
                    },
                    0);

                    renderViewKasir();

                    handleManageHutang();
                    handleDisplayInput();
                    handleButtonBayar();

                    pembelian.pembelian_product.map((value, index) => {
                        const barang_id = value.barang_id;
                        changeHandleInput(barang_id);

                        handleManageHutang();
                        handleDisplayInput();
                        handleButtonBayar();
                    });

                    // render pembelian pembayaran
                    pembelian.pembelian_pembayaran.map((value, index) => {
                        renderMetodePembayaran(value.kategori_pembayaran_id);

                        metodePembayaran[index].kategori_pembayaran_selected =
                            value.kategori_pembayaran;

                        metodePembayaran[index].sub_pembayaran_selected =
                            value.sub_pembayaran;

                        metodePembayaran[index].user_selected = value.users;

                        metodePembayaran[index].supplier = pembelian.supplier;

                        metodePembayaran[index].bayar =
                            value.bayar_pbpembayaran;

                        metodePembayaran[index].dibayarkan_oleh =
                            value.dibayaroleh_pbpembayaran;

                        metodePembayaran[index].kembalian =
                            value.kembalian_pbpembayaran;

                        metodePembayaran[index].hutang =
                            value.hutang_pbpembayaran;

                        metodePembayaran[index].nomor_kartu =
                            value.nomorkartu_pbpembayaran;

                        metodePembayaran[index].nama_pemilik_kartu =
                            value.pemilikkartu_pbpembayaran;
                    });

                    handleManageHutang();
                    handleButtonBayar();
                    const output = viewMetodePembayaran();
                    $(".output_metode_pembayaran").html(output);
                },
            });
        }
    };
    renderEditData();

    const renderSupplier = (value) => {
        if (value !== "" && value !== null) {
            const searchSupplier = jsonString.find((item) => item.id == value);
            supplierId = searchSupplier.id;
            $(".load_supplier_id").html(`
        <table class="w-100">
            <thead>
                <tr>
                    <th class="text-primary fw-bold">Nama Supplier</th>
                    <th class="text-primary fw-bold">No. HP</th>
                    <th class="text-primary fw-bold">Deskripsi</th>
                    <th class="text-primary fw-bold">Perusahaan</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>${searchSupplier.nama_supplier}</td>
                    <td>${searchSupplier.nowa_supplier}</td>
                    <td>${searchSupplier.deskripsi_supplier}</td>
                    <td>${searchSupplier.perusahaan_supplier}</td>
                </tr>
            </tbody>
        </table>
        `);
        } else {
            $(".load_supplier_id").html("");
        }
    };

    body.on("change", 'select[name="supplier_id"]', function (e) {
        const value = $(this).val();
        renderSupplier(value);
    });

    const renderBarang = (value) => {
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

            handleManageHutang();
            handleDisplayInput();
            handleButtonBayar();
        }
    };
    body.on("change", 'select[name="barang_id"]', function (e) {
        const value = $(this).val();
        if (value != "-" && value != null && value != "") {
            renderBarang(value);
        }
    });

    body.on("input", 'input[name="qty"]', function () {
        const id = $(this).data("id");
        changeHandleInput(id);

        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });
    body.on("change", 'select[name="type_discount"]', function () {
        const id = $(this).data("id");
        changeHandleInput(id);

        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });
    body.on("input", 'input[name="jumlah_diskon"]', function () {
        const id = $(this).data("id");
        changeHandleInput(id);

        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
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

        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    const renderMetodePembayaran = (value) => {
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

            // supplier
            const valueSupplier = $(
                'select[name="supplier_id"] option:selected'
            ).val();
            const getSupplier = jsonString.find(
                (item) => item.id == valueSupplier
            );

            dataMetodePembayaran.kategori_pembayaran = jsonKategoriPembayaran;
            dataMetodePembayaran.kategori_pembayaran_selected =
                getKategoriPembayaran;
            dataMetodePembayaran.sub_pembayaran = getSubPembayaran;
            dataMetodePembayaran.sub_pembayaran_selected = {};
            dataMetodePembayaran.user = jsonDataUser;
            dataMetodePembayaran.user_selected = defaultUser;
            dataMetodePembayaran.supplier = getSupplier;
            dataMetodePembayaran.bayar = 0;
            dataMetodePembayaran.dibayarkan_oleh =
                getSupplier && getSupplier.nama_supplier;
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
        $(".output_metode_pembayaran").html(output);
    };

    body.on("click", ".btn-add-pembayaran", function (e) {
        e.preventDefault();
        const value = $(
            'select[name="kategori_pembayaran_id"] option:selected'
        ).val();
        renderMetodePembayaran(value);
    });

    body.on("click", ".btn-delete-pembayaran", function (e) {
        e.preventDefault();
        const index = $(this).data("index");
        metodePembayaran.splice(index, 1);

        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
        const output = viewMetodePembayaran();
        $(".output_metode_pembayaran").html(output);
    });

    body.on("input", 'input[name="bayar"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("change", 'select[name="kategori_pembayaran_id_mp"]', function () {
        const index = $(this).data("index");
        const value = $(this).val();
        if (value !== null && value !== "") {
            handeMetodePembayaran(index);
            handleAnotherMethodLangsung();
            handleManageHutang();
            handleDisplayInput();
            handleButtonBayar();
            handleSubPembayaran(index);

            const output = viewMetodePembayaran();
            $(".output_metode_pembayaran").html(output);
        }
    });

    body.on("change", 'select[name="sub_pembayaran_id_mp"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("input", 'input[name="nomor_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("input", 'input[name="nama_pemilik_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("change", 'select[name="akun"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.on("input", 'input[name="dibayar_oleh"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    const payloadKasir = () => {
        const indexLast = metodePembayaran.length - 1;
        const getHutang = parseFloat(metodePembayaran[indexLast].hutang);
        const getBayar = metodePembayaran.reduce((total, item) => {
            return parseFloat(total) + parseFloat(item.bayar);
        }, 0);

        const payloadPembelian = {
            invoice_pembelian: jsonNoInvoice,
            transaksi_pembelian: formatDate(),
            supplier_id: supplierId,
            tipe_pembelian: getHutang > 0 ? "hutang" : "cash",
            users_id: jsonDefaultUser,
            cabang_id: jsonCabangId,
            total_pembelian: parseFloat(totalHargaItems),
            hutang_pembelian: metodePembayaran[indexLast].hutang,
            kembalian_pembelian: metodePembayaran[indexLast].kembalian,
            bayar_pembelian: getBayar,
        };

        const payloadPembelianProduct = [];
        orderItems.map((value, index) => {
            payloadPembelianProduct.push({
                transaksi_pembelianproduct: formatDate(),
                supplier_id: supplierId,
                barang_id: value.id,
                jumlah_pembelianproduct: value.qty,
                typediskon_pembelianproduct: value.tipeDiskon,
                diskon_pembelianproduct: value.jumlahDiskon,
                subtotal_pembelianproduct: value.totalHarga,
                cabang_id: jsonCabangId,
            });
        });

        const payloadPembelianPembayaran = [];
        metodePembayaran.map((value, index) => {
            payloadPembelianPembayaran.push({
                kategori_pembayaran_id: value.kategori_pembayaran_selected.id,
                sub_pembayaran_id: value.sub_pembayaran_selected.id,
                bayar_pbpembayaran: value.bayar,
                dibayaroleh_pbpembayaran:
                    value.dibayarkan_oleh === undefined
                        ? ""
                        : value.dibayarkan_oleh,
                users_id: value.user_selected.id,
                kembalian_pbpembayaran: value.kembalian,
                hutang_pbpembayaran: value.hutang,
                nomorkartu_pbpembayaran:
                    value.nomor_kartu === undefined ? "" : value.nomor_kartu,
                pemilikkartu_pbpembayaran:
                    value.nama_pemilik_kartu === undefined
                        ? ""
                        : value.nama_pemilik_kartu,
                cabang_id: jsonCabangId,
            });
        });

        const payloadIsEdit = {
            isEdit: $(".isEdit").data("value"),
            pembelian_id: $(".pembelian_id").data("value"),
        };

        const payload = {
            pembelian: payloadPembelian,
            pembelian_product: payloadPembelianProduct,
            pembelian_pembayaran: payloadPembelianPembayaran,
            payload_is_edit: payloadIsEdit,
        };

        return payload;
    };

    const renderPrintKasir = (outputData) => {
        var output = "";
        $.ajax({
            url: $(".url_print_kasir").data("url"),
            dataType: "json",
            type: "get",
            data: {
                pembelian_id: outputData,
            },
            dataType: "text",
            async: false,
            success: function (data) {
                output = data;
            },
        });

        return output;
    };

    body.on("click", ".btn-confirm-bayar", function (e) {
        e.preventDefault();

        $.ajax({
            type: "post",
            url: $(".url_simpan_kasir").data("url"),
            data: payloadKasir(),
            dataType: "json",
            beforeSend: function () {
                clearError422();
                $(".btn-confirm-bayar").attr("disabled", true);
                $(".btn-confirm-bayar").html(disableButton);
            },
            success: function (data) {
                runToast({
                    title: "Successfully",
                    description: data.message,
                    type: "bg-success",
                });

                const output = renderPrintKasir(data.result);
                printOutput(output);

                // tutup modal
                $("#modalConfirmBayar").modal("hide");

                // reset data
                resetData();
                refreshDataSet();
            },
            error: function (jqXHR, exception) {
                $(".btn-confirm-bayar").attr("disabled", false);
                $(".btn-confirm-bayar").html(enableButton);
                if (jqXHR.status === 422) {
                    showErrors422(jqXHR);
                }
            },
            complete: function () {
                $(".btn-confirm-bayar").attr("disabled", false);
                $(".btn-confirm-bayar").html(enableButton);
            },
        });
    });
});
