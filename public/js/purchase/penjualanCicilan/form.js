// "use strict";
var jsonKategoriPembayaran = $(".json_kategori_pembayaran").data("json");
var jsonArrayKategoriPembayaran = $(".json_array_kategori_pembayaran").data(
    "json"
);
var jsonSubPembayaran = $(".json_sub_pembayaran").data("json");
var jsonArraySubPembayaran = $(".json_array_sub_pembayaran").data("json");
var jsonDataUser = $(".json_data_user").data("json");
var jsonDefaultUser = $(".json_default_user").data("json");
var jsonCabangId = $(".json_cabang_id").data("json");
var jsonPenjualanId = $(".penjualan_id").data("value");

var body = $("body");
var metodePembayaran = [];
var totalHargaItems = $(".totalHutang").data("value");

$(document).ready(function () {
    select2Standard({
        parent: "#extraLargeModal",
        selector: "select[name='kategori_pembayaran_id']",
    });

    const refreshDataSet = () => {
        $.ajax({
            url: $(".url_purchase_kasir").data("url"),
            type: "get",
            data: {
                refresh_dataset: true,
            },
            dataType: "json",
            success: function (data) {
                jsonKategoriPembayaran = JSON.parse(data.kategoriPembayaran);
                jsonArrayKategoriPembayaran = JSON.parse(
                    data.array_kategori_pembayaran
                );
                jsonSubPembayaran = JSON.parse(data.subPembayaran);
                jsonArraySubPembayaran = JSON.parse(data.array_sub_pembayaran);
                jsonDataUser = JSON.parse(data.dataUser);
                jsonDefaultUser = data.defaultUser;
                jsonCabangId = data.cabangId;
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

                $(".header_bayar_penjualan").html(
                    number_format(data.getPenjualan.bayar, 0, ".", ",")
                );
                $(".header_hutang_penjualan").html(
                    number_format(data.getPenjualan.hutang, 0, ".", ",")
                );
                $(".header_kembalian_penjualan").html(
                    number_format(data.getPenjualan.kembalian, 0, ".", ",")
                );
                if (data.getPenjualan.status_transaksi) {
                    $(".btn-add").attr("disabled", true);
                    $(".btn-add").html("Lunas");
                } else {
                    $(".btn-add").attr("disabled", false);
                    $(".btn-add").html(`
                    <span>
                        <i class="bx bx-plus me-sm-1"></i>
                        Tambah
                    </span>
                `);
                }
            },
        });
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
        metodePembayaran.map((v,index) => {
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
        })
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
        metodePembayaran = [];
        handleButtonBayar();
        $(".output_metode_pembayaran").html("");
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
                data: {
                    refresh_dataset: true,
                },
                dataType: "json",
                success: function (data) {
                    const penjualan = data.penjualan;
                    handleManageHutang();
                    handleDisplayInput();
                    handleButtonBayar();
                    // render penjualan pembayaran
                    penjualan.penjualan_cicilan.map((value, index) => {
                        renderMetodePembayaran(value.kategori_pembayaran_id);
                        metodePembayaran[index].kategori_pembayaran_selected =
                            value.kategori_pembayaran;
                        metodePembayaran[index].sub_pembayaran_selected =
                            value.sub_pembayaran;
                        metodePembayaran[index].user_selected = value.users;
                        metodePembayaran[index].customer = penjualan.customer;
                        metodePembayaran[index].bayar = value.bayar_pcicilan;
                        metodePembayaran[index].dibayarkan_oleh =
                            value.dibayaroleh_pcicilan;
                        metodePembayaran[index].kembalian =
                            value.kembalian_pcicilan;
                        metodePembayaran[index].hutang = value.hutang_pcicilan;
                        metodePembayaran[index].nomor_kartu =
                            value.nomorkartu_pcicilan;
                        metodePembayaran[index].nama_pemilik_kartu =
                            value.pemilikkartu_pcicilan;
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
            dataMetodePembayaran.kategori_pembayaran = jsonKategoriPembayaran;
            dataMetodePembayaran.kategori_pembayaran_selected =
                getKategoriPembayaran;
            dataMetodePembayaran.sub_pembayaran = getSubPembayaran;
            dataMetodePembayaran.sub_pembayaran_selected = {};
            dataMetodePembayaran.user = jsonDataUser;
            dataMetodePembayaran.user_selected = defaultUser;
            dataMetodePembayaran.bayar = 0;
            dataMetodePembayaran.dibayarkan_oleh = "";
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

    body.off("click", ".btn-add-pembayaran");
    body.on("click", ".btn-add-pembayaran", function (e) {
        e.preventDefault();
        const value = $(
            'select[name="kategori_pembayaran_id"] option:selected'
        ).val();
        renderMetodePembayaran(value);
    });

    body.off("click", ".btn-delete-pembayaran");
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

    body.off("input", 'input[name="bayar"]');
    body.on("input", 'input[name="bayar"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("change", 'select[name="kategori_pembayaran_id_mp"]');
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

    body.off("change", 'select[name="sub_pembayaran_id_mp"]');
    body.on("change", 'select[name="sub_pembayaran_id_mp"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("input", 'input[name="nomor_kartu"]');
    body.on("input", 'input[name="nomor_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("input", 'input[name="nama_pemilik_kartu"]');
    body.on("input", 'input[name="nama_pemilik_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("change", 'select[name="akun"]');
    body.on("change", 'select[name="akun"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageHutang();
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("input", 'input[name="dibayar_oleh"]');
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

        const payloadPenjualan = {
            tipe_penjualan: getHutang > 0 ? "hutang" : "cash",
            hutang_penjualan: metodePembayaran[indexLast].hutang,
            kembalian_penjualan: metodePembayaran[indexLast].kembalian,
            bayar_penjualan: getBayar,
            penjualan_id: jsonPenjualanId,
        };

        const payloadPenjualanCicilan = [];
        metodePembayaran.map((value, index) => {
            payloadPenjualanCicilan.push({
                kategori_pembayaran_id: value.kategori_pembayaran_selected.id,
                sub_pembayaran_id: value.sub_pembayaran_selected.id,
                bayar_pcicilan: value.bayar,
                dibayaroleh_pcicilan:
                    value.dibayarkan_oleh === undefined
                        ? ""
                        : value.dibayarkan_oleh,
                users_id: value.user_selected.id,
                kembalian_pcicilan: value.kembalian,
                hutang_pcicilan: value.hutang,
                nomorkartu_pcicilan:
                    value.nomor_kartu === undefined ? "" : value.nomor_kartu,
                pemilikkartu_pcicilan:
                    value.nama_pemilik_kartu === undefined
                        ? ""
                        : value.nama_pemilik_kartu,
                penjualan_id: jsonPenjualanId,
                cabang_id: jsonCabangId,
            });
        });
        const payloadIsEdit = {
            isEdit: $(".isEdit").data("value"),
            penjualan_id: jsonPenjualanId,
        };
        const payload = {
            penjualan: payloadPenjualan,
            penjualan_cicilan: payloadPenjualanCicilan,
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
                penjualan_id: outputData,
            },
            dataType: "text",
            async: false,
            success: function (data) {
                output = data;
            },
        });
        return output;
    };

    body.off("click", ".popover.close");
    body.on("click", ".popover.close", function (e) {
        e.preventDefault();
        $("#btn-pop-over").popover("hide");
    });

    body.off("click", ".btn-confirm-bayar");
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
                $("#btn-pop-over").popover("hide");

                // reset data
                resetData();
                refreshDataSet();
                datatable.ajax.reload();
                myModal.hide();
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
