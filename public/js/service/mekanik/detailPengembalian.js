const runDataPengembalian = () => {
    // "use strict";
    var myModal;
    var urlRoot = $(".url_root").data("url");
    var jsonPenerimaanServisId = $(".penerimaan_servis_id").data("value");
    var body = $("body");

    // to pembayaran
    var jsonKategoriPembayaran = $(".json_kategori_pembayaran").data("json");
    var jsonSubPembayaran = $(".json_sub_pembayaran").data("json");
    var jsonDataUser = $(".json_data_user").data("json");
    var jsonCabangId = $(".json_cabang_id").data("json");
    var row = $(".jsonRow").data("json");

    var jsonDefaultUser = $(".defaultUser").data("value");
    var getPembayaranServis = $(".getPembayaranServis").data("value");

    var metodePembayaran = [];
    var totalHargaItems = $(".totalHutang").data("value");
    var saldoDepositCustomer = row.customer.saldo_customer.jumlah_saldocustomer;
    var customerId = row.customer.id;
    // end to pembayaran

    $(document).ready(function () {
        select2Standard({
            parent: ".content-wrapper",
            selector: "select[name='tipeberkala_pservis']",
        });
        select2Standard({
            parent: ".content-wrapper",
            selector: "select[name='tipegaransi_pservis']",
        });
        select2Standard({
            parent: ".content-wrapper",
            selector: "select[name='kategori_pembayaran_id']",
        });

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
                            v.id ===
                            (value.user_selected && value.user_selected.id)
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
                    if (
                        value.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() !==
                        "deposit"
                    ) {
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
                                v.id ===
                                (value.user_selected && value.user_selected.id)
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
                    } else {
                        output += `
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="row">
                                <div class="col-lg-8">
                                    <h5 class="m-0 p-0">Pembayaran Deposit:</h5>
                                </div>
                                <div class="col-lg-4">
                                    <button class="btn btn-delete-pembayaran" title="Hapus item" data-index="${index}">
                                        <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Saldo Deposit</label>
                                <input class="form-control" type="text" name="saldo_deposit" data-index="${index}"
                                    placeholder="Saldo Deposit..."
                                    value="${number_format(
                                        value.saldo_deposit,
                                        0,
                                        ".",
                                        ","
                                    )}" disabled>
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
                    </div>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label for="">Sisa Saldo</label>
                                <input class="form-control" type="text" name="sisasaldo_deposit" data-index="${index}" placeholder="Sisa saldo..." value="${number_format(
                            value.sisasaldo_deposit,
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
                    }
                }
            });
            return output;
        };

        const handleAnotherMethodLangsung = () => {
            metodePembayaran.map((v, index) => {
                const getMetodePembayaran = metodePembayaran[index];
                const namaMetodePembayaran =
                    getMetodePembayaran.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase();
                if (
                    namaMetodePembayaran !== "langsung" &&
                    namaMetodePembayaran !== "deposit"
                ) {
                    if (index === 0) {
                        if (
                            parseFloat(getMetodePembayaran.bayar) >
                            totalHargaItems
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

                if (namaMetodePembayaran === "deposit") {
                    const saldoDeposit = saldoDepositCustomer;
                    const totalHutang = totalHargaItems;
                    // // handle deposit dahulu
                    if (index === 0) {
                        if (
                            parseFloat(getMetodePembayaran.bayar) >
                            parseFloat(totalHutang)
                        ) {
                            metodePembayaran[index].bayar = totalHutang;
                        }

                        if (
                            parseFloat(getMetodePembayaran.bayar) >
                            parseFloat(saldoDeposit)
                        ) {
                            metodePembayaran[index].bayar = saldoDeposit;
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

                        const dataDeposit = metodePembayaran
                            .filter(
                                (item) =>
                                    item.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() ===
                                    "deposit"
                            )
                            .filter((item) => item.index < index);

                        const lastDeposit = dataDeposit.length - 1;
                        const getLastDataNow = dataDeposit[lastDeposit];
                        const getIndexDeposit = getLastDataNow.index;

                        const findDataIndex = metodePembayaran.findIndex(
                            (item) => item.index === getIndexDeposit
                        );
                        if (findDataIndex !== -1) {
                            const sisasaldo_deposit_before =
                                metodePembayaran[findDataIndex]
                                    .sisasaldo_deposit;
                            if (
                                parseFloat(getMetodePembayaran.bayar) >
                                parseFloat(sisasaldo_deposit_before)
                            ) {
                                metodePembayaran[index].bayar =
                                    sisasaldo_deposit_before;
                            }
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
                $(
                    `select[name="sub_pembayaran_id_mp"][data-index="${index}"]`
                ).val(
                    value.sub_pembayaran_selected &&
                        value.sub_pembayaran_selected.id
                );
                $(`input[name="sisasaldo_deposit"][data-index="${index}"]`).val(
                    formatNumber(value.sisasaldo_deposit)
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
                $(
                    `input[name="nama_pemilik_kartu"][data-index="${index}"]`
                ).val(value.nama_pemilik_kartu);
            });
        };

        const handeMetodePembayaran = (index) => {
            const checkMetodePembayaran =
                metodePembayaran[index].kategori_pembayaran_selected;
            let kategori_pembayaran_id = checkMetodePembayaran.id;
            let sub_pembayaran_id =
                metodePembayaran[index].sub_pembayaran_selected &&
                metodePembayaran[index].sub_pembayaran_selected.id;

            if (
                checkMetodePembayaran.nama_kpembayaran.toLowerCase() !==
                "deposit"
            ) {
                kategori_pembayaran_id = $(
                    `select[name="kategori_pembayaran_id_mp"][data-index="${index}"]`
                ).val();
                sub_pembayaran_id = $(
                    `select[name="sub_pembayaran_id_mp"][data-index="${index}"]`
                ).val();
            }

            let users_id = $(
                `select[name="akun"][data-index="${index}"]`
            ).val();
            if (
                metodePembayaran[
                    index
                ].kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() ===
                "deposit"
            ) {
                users_id = metodePembayaran[index].user_selected.id;
            }

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
            let getKategoriPembayaran =
                metodePembayaran[index].kategori_pembayaran;
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

        const handleIndexArray = () => {
            metodePembayaran.map((value, index) => {
                metodePembayaran[index].index = index;
            });
        };

        const handleManageDeposit = () => {
            metodePembayaran.map((v, index) => {
                if (
                    v.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() ===
                    "deposit"
                ) {
                    if (index === 0) {
                        const bayar = metodePembayaran[index].bayar;
                        const saldo_deposit = saldoDepositCustomer;
                        const kalkulasi = bayar - saldo_deposit;

                        let sisaSaldoNow = 0;
                        if (kalkulasi < 0) {
                            sisaSaldoNow = Math.abs(kalkulasi);
                        } else {
                            sisaSaldoNow = 0;
                        }

                        metodePembayaran[index].saldo_deposit = saldo_deposit;
                        metodePembayaran[index].sisasaldo_deposit =
                            sisaSaldoNow;
                    }

                    if (index > 0) {
                        const dataDeposit = metodePembayaran
                            .filter(
                                (item) =>
                                    item.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() ===
                                    "deposit"
                            )
                            .filter((item) => item.index < index);

                        const lastDeposit = dataDeposit.length - 1;
                        const getLastDataNow = dataDeposit[lastDeposit];
                        const getIndexDeposit = getLastDataNow.index;

                        const findDataIndex = metodePembayaran.findIndex(
                            (item) => item.index === getIndexDeposit
                        );

                        if (findDataIndex !== -1) {
                            const getLastBayarDeposit =
                                metodePembayaran[findDataIndex];
                            const saldo_deposit =
                                getLastBayarDeposit.sisasaldo_deposit;
                            const bayar = metodePembayaran[index].bayar;

                            const kalkulasi = bayar - saldo_deposit;
                            let sisaSaldoNow = 0;
                            if (kalkulasi < 0) {
                                sisaSaldoNow = Math.abs(kalkulasi);
                            } else {
                                sisaSaldoNow = 0;
                            }

                            metodePembayaran[index].saldo_deposit =
                                saldo_deposit;
                            metodePembayaran[index].sisasaldo_deposit =
                                sisaSaldoNow;
                        }
                    }
                }
            });
        };

        const handleButtonBayar = () => {
            let buttonDisabledTidakLangsung = false;
            let buttonDisabledLangsung = false;
            let buttonDisabledDeposit = false;
            let buttonDisabled;
            metodePembayaran.map((value, index) => {
                if (
                    value.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() !==
                        "langsung" &&
                    value.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() !==
                        "deposit"
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
                        value.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() !==
                        "deposit"
                    ) {
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
                    } else {
                        if (
                            value.kategori_pembayaran_selected === undefined ||
                            value.bayar === ""
                        ) {
                            buttonDisabledDeposit = true;
                        } else {
                            buttonDisabledDeposit = false;
                        }
                    }
                }
            });
            buttonDisabled =
                buttonDisabledTidakLangsung ||
                buttonDisabledLangsung ||
                buttonDisabledDeposit;
            $(".btn-submit-data").attr("disabled", buttonDisabled);
        };
        handleButtonBayar();

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

        const renderDeposit = () => {
            const getKategoriPembayaran = jsonKategoriPembayaran.find(
                (item) => item.nama_kpembayaran.toLowerCase() == "deposit"
            );

            const getSubPembayaran = jsonSubPembayaran.find(
                (item) =>
                    item.kategori_pembayaran_id == getKategoriPembayaran.id
            );
            const userSelected = jsonDataUser.find(
                (item) => item.id == jsonDefaultUser
            );

            let dataMetodePembayaran = {};
            dataMetodePembayaran.kategori_pembayaran = jsonKategoriPembayaran;
            dataMetodePembayaran.kategori_pembayaran_selected =
                getKategoriPembayaran;
            dataMetodePembayaran.sub_pembayaran = jsonSubPembayaran;
            dataMetodePembayaran.sub_pembayaran_selected = getSubPembayaran;
            dataMetodePembayaran.user = jsonDataUser;
            dataMetodePembayaran.user_selected = userSelected;
            dataMetodePembayaran.bayar = 0;
            dataMetodePembayaran.dibayarkan_oleh = row.customer.nama_customer;
            dataMetodePembayaran.kembalian = getPembayaranServis.kembalian;
            dataMetodePembayaran.hutang = getPembayaranServis.hutang;
            dataMetodePembayaran.nomor_kartu = "";
            dataMetodePembayaran.nama_pemilik_kartu = "";
            dataMetodePembayaran.saldo_deposit = saldoDepositCustomer;
            dataMetodePembayaran.sisasaldo_deposit = saldoDepositCustomer;
            dataMetodePembayaran.index = 0;
            metodePembayaran.push(dataMetodePembayaran);

            handleIndexArray();
            handleManageDeposit();
            handleManageHutang();
            handleButtonBayar();
            const output = viewMetodePembayaran();
            $(".output_metode_pembayaran").html(output);
        };

        const refreshDataArea = () => {
            $.ajax({
                url: `${urlRoot}/service/kendaraanServis/${jsonPenerimaanServisId}`,
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
                            "sudah diambil"
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

        const viewOrderBarangKendaraan = (rowData) => {
            const orderBarang = rowData.order_barang;

            let output = ``;
            let no = 1;

            orderBarang.map((item) => {
                output += `
                <tr>
                    <td>${no++}</td>
                    <td>${item.barang.nama_barang}</td>
                    <td>${formatUang(item.barang.hargajual_barang)}</td>
                    <td>${formatUang(item.qty_orderbarang)}</td>
                    <td> ${capitalizeEachWord(
                        item.typediskon_orderbarang == null
                            ? ""
                            : item.typediskon_orderbarang
                    )} </td>
                    <td>${formatUang(
                        item.diskon_orderbarang == null
                            ? 0
                            : item.diskon_orderbarang
                    )} </td>
                    <td>${formatUang(item.subtotal_orderbarang)} </td>
                </tr>
                `;
            });

            return output;
        };

        const refreshData = () => {
            $.ajax({
                url: `${urlRoot}/service/kendaraanServis/${jsonPenerimaanServisId}`,
                dataType: "json",
                type: "get",
                data: {
                    refresh: true,
                },
                success: function (data) {
                    jsonPenerimaanServisId = data.penerimaanServisId;
                    jsonKategoriPembayaran = JSON.parse(
                        data.kategoriPembayaran
                    );
                    jsonSubPembayaran = JSON.parse(data.subPembayaran);
                    jsonDataUser = JSON.parse(data.dataUser);
                    jsonCabangId = data.cabangId;
                    jsonDefaultUser = data.defaultUser;
                    is_deposit = data.is_deposit;
                    getPembayaranServis = JSON.parse(data.getPembayaranServis);
                    totalHargaItems = data.totalHutang;
                    saldoDepositCustomer =
                        data.row.customer.saldo_customer.jumlah_saldocustomer;
                    customerId = data.row.customer.id;

                    // output servis history
                    const rowData = data.row;
                    viewServiceHistori(rowData);

                    // handle deposit
                    if (data.is_deposit) {
                        renderDeposit();
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
                    $(".output_tanggalambil_pservis").html(
                        formatDateFromDb(rowData.tanggalambil_pservis)
                    );
                    $(".output_bayar_pservis").html(
                        formatUang(rowData.bayar_pservis)
                    );
                    $(".output_kembalian_pservis").html(
                        formatUang(rowData.kembalian_pservis)
                    );
                    $(".if_status_cancel").html(
                        `<i class="fa-solid fa-pen me-2"></i> ${capitalizeEachWord(rowData.status_pservis)}`
                    );

                    // handle pembayaran servis
                    const tanggalambil_pservis = data.row.tanggalambil_pservis;
                    let outputPServis = "";
                    const statusCancel = ["cancel", "tidak bisa", "komplain garansi", "sudah diambil"];

                    if (
                        tanggalambil_pservis != null ||
                        statusCancel.includes(rowData.status_pservis)
                    ) {
                        const pembayaranServis = data.row.pembayaran_servis;
                        pembayaranServis.map((v, i) => {
                            if (i === 0 && pembayaranServis.length > 1) {
                                return;
                            }

                            if (
                                v.kategori_pembayaran.nama_kpembayaran.toLowerCase() ===
                                "deposit"
                            ) {
                                outputPServis += `
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <h5 class="m-0 p-0">Pembayaran Deposit:</h5>
                                                </div>
                                                <div class="col-lg-4">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Saldo Deposit</label> <br />
                                                <span>${formatUang(
                                                    v.saldodeposit_pservis
                                                )}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Bayar</label> <br />
                                                ${formatUang(v.bayar_pservis)}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Sisa Saldo</label> <br />
                                                ${formatUang(v.deposit_pservis)}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Hutang</label> <br />
                                                ${formatUang(v.hutang_pservis)}
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="color: #1381f0;" />
                                    `;
                            }
                            if (
                                v.kategori_pembayaran.nama_kpembayaran.toLowerCase() ===
                                "langsung"
                            ) {
                                outputPServis += `
                                    <div class="row mb-3">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <h5 class="m-0 p-0">${
                                                    v.kategori_pembayaran
                                                        .nama_kpembayaran
                                                }</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                              <h5 class="m-0 p-0">${
                                                  v.sub_pembayaran
                                                      .nama_spembayaran
                                              }</h5>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Bayar</label><br />
                                                ${formatUang(v.bayar_pservis)}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Dibayar Oleh</label> <br />
                                                ${v.dibayaroleh_pservis}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Akun</label> <br />
                                               <span>${v.users.name}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Kembalian</label> <br />
                                                <span>${formatUang(
                                                    v.kembalian_pservis
                                                )}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Hutang</label> <br />
                                                <span>${formatUang(
                                                    v.hutang_pservis
                                                )}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <hr style="color: #1381f0;" />
                                    `;
                            }
                            if (
                                v.kategori_pembayaran.nama_kpembayaran.toLowerCase() !==
                                    "langsung" &&
                                v.kategori_pembayaran.nama_kpembayaran.toLowerCase() !==
                                    "deposit"
                            ) {
                                outputPServis += `
                                    <div class="row mt-3">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>${v.kategori_pembayaran.nama_kpembayaran}</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label>${v.sub_pembayaran.nama_spembayaran}</label>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Nomor Kartu</label> <br />
                                                ${v.nomorkartu_pservis}
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="form-group">
                                                <label for="">Nama Pemilik Kartu</label><br />
                                                ${v.pemilikkartu_pservis}
                                            </div>
                                        </div>
                                    </div>
                                    `;
                            }
                        });
                        $(".output_metode_pembayaran").html(outputPServis);
                    }
                    // end handle metode pembayaran

                    // handle dom html
                    if (tanggalambil_pservis != null) {
                        $(".label_total_dppservis").closest(".row").hide();

                        $(".display_after_bisa_diambil").removeClass("d-none");
                        $(".hidden_tanggal_diambil").addClass("d-none");
                    } else {
                        const statusCancel = ["cancel", "tidak bisa", "komplain garansi", "sudah diambil"];
                        if (statusCancel.includes(rowData.status_pservis)) {
                            $(".label_total_dppservis").closest(".row").hide();
                            $(".display_after_bisa_diambil").removeClass(
                                "d-none"
                            );
                            $(".hidden_tanggal_diambil").addClass("d-none");
                        } else {
                            $(".label_total_dppservis").closest(".row").show();

                            $(".display_after_bisa_diambil").addClass("d-none");
                            $(".hidden_tanggal_diambil").removeClass("d-none");
                        }
                    }
                    // end handle dom html

                    if (
                        rowData.status_pservis == "bisa diambil" ||
                        statusCancel.includes(rowData.status_pservis)
                    ) {
                        $(".output_nilaiberkala_pservis").html(
                            rowData.nilaiberkala_pservis
                        );
                        $(".output_tipeberkala_pservis").html(
                            rowData.tipeberkala_pservis
                        );
                        $(".output_catatanteknisi_pservis").html(
                            rowData.catatanteknisi_pservis
                        );
                        $(".output_kondisiservis_pservis").html(
                            rowData.kondisiservis_pservis
                        );
                        $(".output_pesanwa_pservis").html(
                            rowData.pesanwa_pservis || rowData.pesanwa_berkala
                        );
                        $(".output_nilaigaransi_pservis").html(
                            rowData.nilaigaransi_pservis
                        );
                        $(".output_tipegaransi_pservis").html(
                            rowData.tipegaransi_pservis
                        );
                        $(".output_servisgaransi_pservis").html(
                            `
                                <div class="form-group">
                                    <strong>Masa Berlaku Garansi: </strong> <br />
                                    ${formatDateIndonesia(
                                        rowData.servisgaransi_pservis
                                    )}
                                </div>
                                `
                        );

                        if (statusCancel.includes(rowData.status_pservis)) {
                            $(".if_status_cancel").removeClass("d-none");
                        }
                        $(".hidden_after_bisa_diambil").addClass("d-none");
                    } else {
                        $(".hidden_after_bisa_diambil").removeClass("d-none");
                        $(".if_status_cancel").addClass("d-none");
                    }

                    // handle view loadOrderBarangKendaraan
                    const outputOrderBarangKendaraan =
                        viewOrderBarangKendaraan(rowData);
                    $(".loadOrderBarangKendaraan").html(
                        outputOrderBarangKendaraan
                    );

                    // handle view servis penerimaan garansi
                    const garansi_pservis = rowData.garansi_pservis;
                    
                    if (garansi_pservis != null) {
                        $(".output_garansi_pservis").html(garansi_pservis);
                        $(".output_users_id_garansi").html(
                            capitalizeEachWord(rowData.users_id_garansi.name)
                        );
                        $(".display_garansi_pservis").removeClass("d-none");
                        $(".hidden_garansi_pservis").addClass("d-none");
                    } else {
                        $(".display_garansi_pservis").addClass("d-none");
                        $(".hidden_garansi_pservis").removeClass("d-none");
                    }
                },
            });
        };

        refreshData();

        const resetData = () => {
            metodePembayaran = [];
            handleButtonBayar();
            $(".output_metode_pembayaran").html("");
        };

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

                dataMetodePembayaran.kategori_pembayaran =
                    jsonKategoriPembayaran;
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
                dataMetodePembayaran.saldo_deposit = 0;
                dataMetodePembayaran.sisasaldo_deposit = 0;
                dataMetodePembayaran.index = 0;
                metodePembayaran.push(dataMetodePembayaran);
            }

            handleIndexArray();
            handleManageDeposit();
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
            handleIndexArray();
            handleManageDeposit();
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
            handleManageDeposit();
            handleManageHutang();
            handleDisplayInput();
            handleButtonBayar();
        });

        body.off("change", 'select[name="kategori_pembayaran_id"]');
        body.on(
            "change",
            'select[name="kategori_pembayaran_id_mp"]',
            function () {
                const index = $(this).data("index");
                const value = $(this).val();
                if (value !== null && value !== "") {
                    handeMetodePembayaran(index);
                    handleAnotherMethodLangsung();
                    handleManageDeposit();
                    handleManageHutang();
                    handleDisplayInput();
                    handleButtonBayar();
                    handleSubPembayaran(index);
                    const output = viewMetodePembayaran();
                    $(".output_metode_pembayaran").html(output);
                }
            }
        );

        body.off("change", 'select[name="sub_pembayaran_id_mp"]');
        body.on("change", 'select[name="sub_pembayaran_id_mp"]', function () {
            const index = $(this).data("index");
            handeMetodePembayaran(index);
            handleAnotherMethodLangsung();
            handleManageDeposit();
            handleManageHutang();
            handleDisplayInput();
            handleButtonBayar();
        });

        body.off("input", 'input[name="nomor_kartu"]');
        body.on("input", 'input[name="nomor_kartu"]', function () {
            const index = $(this).data("index");
            handeMetodePembayaran(index);
            handleAnotherMethodLangsung();
            handleManageDeposit();
            handleManageHutang();
            handleDisplayInput();
            handleButtonBayar();
        });

        body.off("input", 'input[name="nama_pemilik_kartu"]');
        body.on("input", 'input[name="nama_pemilik_kartu"]', function () {
            const index = $(this).data("index");
            handeMetodePembayaran(index);
            handleAnotherMethodLangsung();
            handleManageDeposit();
            handleManageHutang();
            handleDisplayInput();
            handleButtonBayar();
        });

        body.off("change", 'select[name="akun"]');
        body.on("change", 'select[name="akun"]', function () {
            const index = $(this).data("index");
            handeMetodePembayaran(index);
            handleAnotherMethodLangsung();
            handleManageDeposit();
            handleManageHutang();
            handleDisplayInput();
            handleButtonBayar();
        });

        body.off("input", 'input[name="dibayar_oleh"]');
        body.on("input", 'input[name="dibayar_oleh"]', function () {
            const index = $(this).data("index");
            handeMetodePembayaran(index);
            handleAnotherMethodLangsung();
            handleManageDeposit();
            handleManageHutang();
            handleDisplayInput();
            handleButtonBayar();
        });
        // end benar

        body.off("click", ".detail-customer");
        body.on("click", ".detail-customer", function () {
            showModal({
                url: $(this).data("urlcreate"),
                modalId: $(this).data("typemodal"),
                title: "Detail Kendaraan",
                type: "get",
                data: {
                    pengembalian_servis: true,
                },
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

        // const renderPrintKasir = () => {
        //     var output = "";
        //     $.ajax({
        //         url: `${urlRoot}/service/print/kendaraan/pengembalian`,
        //         dataType: "json",
        //         type: "get",
        //         data: {
        //             penerimaan_servis_id: jsonPenerimaanServisId,
        //         },
        //         dataType: "text",
        //         async: false,
        //         success: function (data) {
        //             output = data;
        //         },
        //     });

        //     return output;
        // };

        // const printOutput = (output) => {
        //     var printWindow = window.open("", "_blank");
        //     printWindow.document.write(output);
        //     printWindow.document.close();
        //     printWindow.print();
        //     printWindow.close();
        // };

        const payloadPengembalian = () => {
            const nilaigaransi_pservis = $(
                'input[name="nilaigaransi_pservis"]'
            ).val();
            const tipegaransi_pservis = $(
                'select[name="tipegaransi_pservis"]'
            ).val();
            const totalBayar = metodePembayaran.reduce((total, item) => {
                return (
                    parseFloat(total) +
                    (item.bayar == ""
                        ? 0
                        : isNaN(item.bayar)
                        ? 0
                        : parseFloat(item.bayar))
                );
            }, 0);
            const lastMetode = metodePembayaran.length - 1;
            const getMetode = metodePembayaran[lastMetode];
            const totalHutang = getMetode.hutang;
            const totalKembalian = getMetode.kembalian;

            const penerimaan_servis = {
                nilaigaransi_pservis: nilaigaransi_pservis,
                tipegaransi_pservis: tipegaransi_pservis,
                bayar_pservis: totalBayar,
                hutang_pservis: totalHutang,
                kembalian_pservis: totalKembalian,
            };

            const getMetodeDeposit = metodePembayaran.filter(
                (item) =>
                    item.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() ===
                    "deposit"
            );
            let sisaSaldoCustomer = 0;
            if (getMetodeDeposit.length > 0) {
                const lastDeposit = getMetodeDeposit.length - 1;
                const indexDataDeposit = getMetodeDeposit[lastDeposit].index;
                const getIndexDeposit = metodePembayaran.findIndex(
                    (item) => item.index === indexDataDeposit
                );
                if (getIndexDeposit !== -1) {
                    const getBayarDeposit =
                        metodePembayaran[getIndexDeposit].sisasaldo_deposit;
                    sisaSaldoCustomer = getBayarDeposit;
                }
            }

            const saldo_customer = {
                customer_id: customerId,
                jumlah_saldocustomer: sisaSaldoCustomer,
                cabang_id: jsonCabangId,
            };

            const saldo_detail = {
                penerimaan_servis_id: jsonPenerimaanServisId,
                totalsaldo_detail: totalBayar,
                kembaliansaldo_detail: totalKembalian,
                hutangsaldo_detail: totalHutang,
                cabang_id: jsonCabangId,
            };

            const pembayaran_servis = [];
            metodePembayaran.map((item) => {
                pembayaran_servis.push({
                    kategori_pembayaran_id:
                        item.kategori_pembayaran_selected.id,
                    sub_pembayaran_id:
                        (item.sub_pembayaran_selected &&
                            item.sub_pembayaran_selected.id) ||
                        "",
                    bayar_pservis: item.bayar,
                    dibayaroleh_pservis: item.dibayarkan_oleh || "",
                    users_id: item.user_selected.id || "",
                    kembalian_pservis: item.kembalian,
                    hutang_pservis: item.hutang,
                    nomorkartu_pservis: item.nomor_kartu || "",
                    pemilikkartu_pservis: item.nama_pemilik_kartu || "",
                    penerimaan_servis_id: jsonPenerimaanServisId,
                    cabang_id: jsonCabangId,
                    saldodeposit_pservis: item.saldo_deposit,
                    deposit_pservis: item.sisasaldo_deposit,
                });
            });

            return {
                pembayaran_servis,
                penerimaan_servis,
                saldo_customer,
                saldo_detail,
            };
        };

        const validateForm = () => {
            let error = false;
            const nilaigaransi_pservis = $(
                'input[name="nilaigaransi_pservis"]'
            ).val();
            const tipegaransi_pservis = $(
                'select[name="tipegaransi_pservis"]'
            ).val();

            if (nilaigaransi_pservis === "" && tipegaransi_pservis !== "") {
                runToast({
                    type: "bg-danger",
                    title: "Form Validation",
                    description:
                        "Jumlah servis berkala atau jenis harian wajib diisi",
                });
                error = true;
            }
            if (nilaigaransi_pservis !== "" && tipegaransi_pservis === "") {
                runToast({
                    type: "bg-danger",
                    title: "Form Validation",
                    description:
                        "Jumlah servis berkala atau jenis harian wajib diisi",
                });
                error = true;
            }
            if (nilaigaransi_pservis === "" && tipegaransi_pservis === "") {
                runToast({
                    type: "bg-danger",
                    title: "Form Validation",
                    description:
                        "Jumlah servis berkala atau jenis harian wajib diisi",
                });
                error = true;
            }

            return error;
        };

        body.off("click", ".btn-submit-data");
        body.on("click", ".btn-submit-data", function (e) {
            e.preventDefault();
            const getValidate = validateForm();

            if (!getValidate) {
                const submitAjaxData = () => {
                    const payload = payloadPengembalian();
                    $.ajax({
                        type: "post",
                        url: `${urlRoot}/service/pengembalianServis/${jsonPenerimaanServisId}/update?_method=put`,
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
                                description: data.message,
                                type: "bg-success",
                            });

                            resetData();
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

                Swal.fire({
                    title: "Konfirmasi",
                    html: `Apakah anda yakin jika transaksi ini sudah benar ? <br /><br />
                    <strong> Proses ini tidak dapat diedit kembali, 
                    jika terjadi kesalahan maka wajib menghapus dan buat dari awal</strong>`,
                    icon: "warning",
                    dangerMode: true,
                    showCancelButton: true,
                    confirmButtonText: "Ya, hapus",
                    cancelButtonText: "Tidak",
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitAjaxData();
                    }
                });
            }
        });
    });

    const renderPrint = (url) => {
        var output = "";
        $.ajax({
            url,
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

    body.off("click", ".btn-print-data");
    body.on("click", ".btn-print-data", function (e) {
        e.preventDefault();
        const url = `${urlRoot}/service/print/kendaraan/selesaiServis?penerimaan_servis_id=${jsonPenerimaanServisId}`;
        const output = renderPrint(url);
        printOutput(output);
    });
};
