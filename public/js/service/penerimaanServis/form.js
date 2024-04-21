var jsonKategoriPembayaran = $(".json_kategori_pembayaran").data("json");
var jsonArrayKategoriPembayaran = $(".json_array_kategori_pembayaran").data(
    "json"
);
var jsonSubPembayaran = $(".json_sub_pembayaran").data("json");
var jsonArraySubPembayaran = $(".json_array_sub_pembayaran").data("json");
var jsonDataUser = $(".json_data_user").data("json");
var jsonDefaultUser = $(".json_default_user").data("json");
var jsonCabangId = $(".json_cabang_id").data("json");
var jsonPembelianId = $(".pembelian_id").data("value");
var jsonDataKendaraan = $(".data_kendaraan").data("value");

var body = $("body");
var metodePembayaran = [];
var totalHargaItems = $(".totalHutang").data("value");
var urlRoot = $(".url_root").data("value");
var penerimaanServisId = $('.penerimaanServisId').data('value');
var isEdit = $(".isEdit").data("value");


datepickerDdMmYyyy(".datepicker");

$(document).ready(function () {
    // benar
    select2Standard({
        parent: "#extraLargeModal",
        selector: "select[name='kategori_servis_id']",
    });
    select2Standard({
        parent: "#extraLargeModal",
        selector: "select[name='kendaraan_id']",
    });
    select2Standard({
        parent: "#extraLargeModal",
        selector: "select[name='tipe_pservis']",
    });
    select2Standard({
        parent: "#extraLargeModal",
        selector: "select[name='kategori_pembayaran_id']",
    });
    // end benar

    // benar
    const refreshDataSet = () => {
        $.ajax({
            url: $(".url_transaction_kasir").data("url"),
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
            },
        });
    };
    // end benar

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
                    <div class="col-lg-8">
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="form-group">
                                    <label for="">Jumlah Deposit</label>
                                    <input class="form-control" type="text" name="jumlah_deposit" data-index="${index}"
                                        placeholder="Masukan Jumlah Deposit..."
                                        value="${number_format(
                                            value.jumlah_deposit,
                                            0,
                                            ".",
                                            ","
                                        )}">
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
    // end benar

    // benar
    const handleDisplayInput = () => {
        metodePembayaran.map((value, index) => {
            $(
                `select[name="kategori_pembayaran_id_mp"][data-index="${index}"]`
            ).val(value.kategori_pembayaran_selected.id);
            $(`select[name="sub_pembayaran_id_mp"][data-index="${index}"]`).val(
                value.sub_pembayaran_selected &&
                    value.sub_pembayaran_selected.id
            );
            $(`input[name="jumlah_deposit"][data-index="${index}"]`).val(
                formatNumber(value.jumlah_deposit)
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
    // end benar

    // benar
    const handeMetodePembayaran = (index) => {
        const kategori_pembayaran_id = $(
            `select[name="kategori_pembayaran_id_mp"][data-index="${index}"]`
        ).val();
        const sub_pembayaran_id = $(
            `select[name="sub_pembayaran_id_mp"][data-index="${index}"]`
        ).val();
        const users_id = $(`select[name="akun"][data-index="${index}"]`).val();
        let jumlah_deposit = $(
            `input[name="jumlah_deposit"][data-index="${index}"]`
        ).val();
        jumlah_deposit = removeCommas(jumlah_deposit);
        jumlah_deposit =
            jumlah_deposit == null
                ? 0
                : isNaN(jumlah_deposit)
                ? 0
                : jumlah_deposit;

        let bayar = $(`input[name="bayar"][data-index="${index}"]`).val();
        bayar = removeCommas(bayar);
        let hutang = $(`input[name="hutang"][data-index="${index}"]`).val();
        hutang = 0;

        let kembalian = $(
            `input[name="kembalian"][data-index="${index}"]`
        ).val();
        kembalian = removeCommas(kembalian);
        kembalian = kembalian == null ? 0 : kembalian;

        const dibayar_oleh = $(
            `input[name="dibayar_oleh"][data-index="${index}"]`
        ).val();
        const nomor_kartu = $(
            `input[name="nomor_kartu"][data-index="${index}"]`
        ).val();
        const nama_pemilik_kartu = $(
            `input[name="nama_pemilik_kartu"][data-index="${index}"]`
        ).val();

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
        metodePembayaran[index].jumlah_deposit = jumlah_deposit;
        metodePembayaran[index].dibayarkan_oleh = dibayar_oleh;
        metodePembayaran[index].user_selected = getUsers;
        metodePembayaran[index].kembalian = kembalian;
        metodePembayaran[index].hutang = hutang;
        metodePembayaran[index].nomor_kartu = nomor_kartu;
        metodePembayaran[index].nama_pemilik_kartu = nama_pemilik_kartu;

        console.log("metode pembayaran", metodePembayaran);
    };
    // end benar

    // benar
    const handleButtonBayar = () => {
        let buttonDisabledTidakLangsung = false;
        let buttonDisabledLangsung = false;
        let buttonDisabledDeposit = false;

        let buttonDisabled;
        let sumBayar = 0;
        let sumDeposit = 0;
        sumBayar = metodePembayaran.reduce((total, item) => {
            return (
                parseFloat(total) +
                (item.bayar == ""
                    ? 0
                    : isNaN(item.bayar)
                    ? 0
                    : parseFloat(item.bayar))
            );
        }, 0);
        sumDeposit = metodePembayaran.reduce((total, item) => {
            return parseFloat(total) + parseFloat(item.jumlah_deposit);
        }, 0);

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
                    value.nomor_kartu === ""
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
                        value.jumlah_deposit === "" ||
                        value.user_selected === undefined ||
                        value.dibayarkan_oleh === ""
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

        if (sumBayar < sumDeposit) {
            buttonDisabledLangsung = true;
            buttonDisabledTidakLangsung = true;
            buttonDisabledDeposit = true;
        }
        buttonDisabled =
            buttonDisabledTidakLangsung ||
            buttonDisabledLangsung ||
            buttonDisabledDeposit;
        $(".btn-bayar").attr("disabled", buttonDisabled);
    };
    // end benar

    // benar
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
    // end benar

    // benar
    const resetData = () => {
        metodePembayaran = [];
        handleButtonBayar();
        $(".output_metode_pembayaran").html("");
    };
    // end benar

    // pending
    const renderEditData = () => {
        if (isEdit == true) {
            $.ajax({
                url: `${urlRoot}/service/penerimaanServis/create?isEdit=true&id=${penerimaanServisId}`,
                type: "get",
                data: {
                    refresh_dataset: true,
                },
                dataType: "json",
                success: function (data) {
                    const pembayaran_servis = data.row.pembayaran_servis;
                    pembayaran_servis.map(v => {
                        const getSubPembayaran = jsonSubPembayaran.filter(
                            (item) =>
                                item.kategori_pembayaran_id == v.kategori_pembayaran.id
                        );
                        let dataMetodePembayaran = {};
                        dataMetodePembayaran.kategori_pembayaran = jsonKategoriPembayaran;
                        dataMetodePembayaran.kategori_pembayaran_selected = v.kategori_pembayaran;
                        dataMetodePembayaran.sub_pembayaran = getSubPembayaran;
                        dataMetodePembayaran.sub_pembayaran_selected = v.sub_pembayaran;
                        dataMetodePembayaran.user = jsonDataUser;
                        dataMetodePembayaran.user_selected = v.users;
                        dataMetodePembayaran.bayar = v.bayar_pservis;
                        dataMetodePembayaran.jumlah_deposit = v.deposit_pservis;
                        dataMetodePembayaran.dibayarkan_oleh = v.dibayaroleh_pservis;
                        dataMetodePembayaran.kembalian = v.kembalian_pservis;
                        dataMetodePembayaran.hutang = v.hutang_pservis;
                        dataMetodePembayaran.nomor_kartu = v.nomorkartu_pservis;
                        dataMetodePembayaran.nama_pemilik_kartu = v.pemilikkartu_pservis;

                        metodePembayaran.push(dataMetodePembayaran);
                    })

                    handleButtonBayar();
                    const output = viewMetodePembayaran();
                    $(".output_metode_pembayaran").html(output);
                },
            });
        }
    };
    renderEditData();
    // end pending

    // benar
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
            dataMetodePembayaran.jumlah_deposit = 0;
            dataMetodePembayaran.dibayarkan_oleh = "";
            dataMetodePembayaran.kembalian = 0;
            dataMetodePembayaran.hutang = 0;
            dataMetodePembayaran.nomor_kartu = "";
            dataMetodePembayaran.nama_pemilik_kartu = "";
            metodePembayaran.push(dataMetodePembayaran);
        }
        handleButtonBayar();
        const output = viewMetodePembayaran();
        $(".output_metode_pembayaran").html(output);
    };
    // end benar

    const formValidation = (getPenerimaanServis) => {
        let error = {};
        let boolean = false;
        if (getPenerimaanServis.kategori_servis_id === "") {
            error.kategori_servis_id = "Kategori Servis wajib diisi";
        }
        if (getPenerimaanServis.keluhan_pservis === "") {
            error.keluhan_pservis = "Keluhan wajib diisi";
        }
        if (getPenerimaanServis.kendaraan_id === "") {
            error.kendaraan_id = "Kendaraan wajib diisi";
        }
        if (getPenerimaanServis.kerusakan_pservis === "") {
            error.kerusakan_pservis = "Kerusakan wajib diisi";
        }
        if (getPenerimaanServis.kondisi_pservis === "") {
            error.kondisi_pservis = "Kondisi kendaraan wajib diisi";
        }
        if (getPenerimaanServis.tipe_pservis === "") {
            error.tipe_pservis = "Tipe Servis wajib diisi";
        }
        let output = "";
        Object.keys(error).map((item) => {
            const message = error[item];
            output += `${message} <br />`;
            boolean = true;
        });
        if (boolean) {
            runToast({
                type: "bg-danger",
                title: "Form Validation",
                description: output,
            });
            $("#btn-pop-over").popover("hide");
        }
        return boolean;
    };

    const initialAwal = () => {
        if($('input[name="isdp_pservis"]').is(':checked')){
            $('.area-pembayaran').removeClass('d-none');
        } else {
            $('.area-pembayaran').addClass('d-none');
        }
    }

    initialAwal();

    // benar
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
        handleDisplayInput();
        handleButtonBayar();
        const output = viewMetodePembayaran();
        $(".output_metode_pembayaran").html(output);
    });
    // end benar

    // benar
    body.off("input", 'input[name="jumlah_deposit"]');
    body.on("input", 'input[name="jumlah_deposit"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        metodePembayaran[index].bayar = metodePembayaran[index].jumlah_deposit;
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("input", 'input[name="bayar"]');
    body.on("input", 'input[name="bayar"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        const getMetodePembayaran = metodePembayaran[index];
        if (
            getMetodePembayaran.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() ===
            "langsung"
        ) {
            let kembalian = getMetodePembayaran.kembalian;
            let bayar = getMetodePembayaran.bayar;
            if (
                parseFloat(getMetodePembayaran.bayar) >
                parseFloat(getMetodePembayaran.jumlah_deposit)
            ) {
                kembalian =
                    parseFloat(getMetodePembayaran.bayar) -
                    parseFloat(getMetodePembayaran.jumlah_deposit);
            }
            if (
                parseFloat(getMetodePembayaran.bayar) <
                parseFloat(getMetodePembayaran.jumlah_deposit)
            ) {
                kembalian = 0;
            }
            metodePembayaran[index].bayar = bayar;
            metodePembayaran[index].kembalian = kembalian;
        }

        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("change", 'select[name="kategori_pembayaran_id_mp"]');
    body.on("change", 'select[name="kategori_pembayaran_id_mp"]', function () {
        const index = $(this).data("index");
        const value = $(this).val();
        if (value !== null && value !== "") {
            handeMetodePembayaran(index);
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
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("input", 'input[name="nomor_kartu"]');
    body.on("input", 'input[name="nomor_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("input", 'input[name="nama_pemilik_kartu"]');
    body.on("input", 'input[name="nama_pemilik_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("change", 'select[name="akun"]');
    body.on("change", 'select[name="akun"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("input", 'input[name="dibayar_oleh"]');
    body.on("input", 'input[name="dibayar_oleh"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleDisplayInput();
        handleButtonBayar();
    });

    body.off("input", 'input[name="isdp_pservis"]');
    body.on("input", 'input[name="isdp_pservis"]', function () {
        if ($(this).is(":checked")) {
            $(".handle-metode-pembayaran").removeClass("d-none");
            $(".btn-bayar").attr("disabled", true);
        } else {
            $(".handle-metode-pembayaran").addClass("d-none");
            $(".btn-bayar").attr("disabled", false);
        }
    });
    // end benar

    body.off("input", 'input[name="isestimasi_pservis"]');
    body.on('click', 'input[name="isestimasi_pservis"]', function () {        
        if($(this).is(":checked")){
            $('.area_estimasi').removeClass('d-none');
        } else {
            $('.area_estimasi').addClass('d-none');
        }
    });

    // pending
    const payloadKasir = () => {
        let sumDeposit = 0;
        let sumKembalian = 0;
        let sumHutang = 0;
        metodePembayaran.map((item) => {
            if (
                item.kategori_pembayaran_selected.nama_kpembayaran.toLowerCase() ===
                "langsung"
            ) {
                sumDeposit += parseFloat(item.jumlah_deposit);
            } else {
                sumDeposit += parseFloat(item.bayar);
            }

            sumKembalian +=
                item.kembalian == "undefined" ? 0 : parseFloat(item.kembalian);
            sumHutang += parseFloat(item.hutang);
        });

        const kendaraan_id = $('select[name="kendaraan_id"]').val();
        let isdp_pservis = 0;
        if ($('input[name="isdp_pservis"]').is(":checked")) {
            isdp_pservis = 1;
        } else {
            isdp_pservis = 0;

            sumDeposit = 0;
            sumKembalian = 0;
            sumHutang = 0;
            metodePembayaran = [];
        }

        let isestimasi_pservis = 0;
        let estimasi_pservis = $('input[name="estimasi_pservis"]').val();
        let keteranganestimasi_pservis = $('textarea[name="keteranganestimasi_pservis"]').val();

        if ($('input[name="isestimasi_pservis"]').is(":checked")) {
            isestimasi_pservis = 1;
        } else {
            isestimasi_pservis = 0;
            estimasi_pservis = null;
            keteranganestimasi_pservis = null;
        }

        const payloadPenerimaanServis = {
            kendaraan_id: kendaraan_id,
            kategori_servis_id: $('select[name="kategori_servis_id"]').val(),
            kerusakan_pservis: $('input[name="kerusakan_pservis"]').val(),
            keluhan_pservis: $('textarea[name="keluhan_pservis"]').val(),
            kondisi_pservis: $('input[name="kondisi_pservis"]').val(),
            kmsekarang_pservis: $('input[name="kmsekarang_pservis"]').val(),
            tipe_pservis: $('select[name="tipe_pservis"]').val(),
            isdp_pservis,
            isestimasi_pservis,
            estimasi_pservis: estimasi_pservis == null ? null : formatDateToDb(estimasi_pservis),
            keteranganestimasi_pservis,
            total_dppservis: sumDeposit,
            bayar_pservis: sumDeposit,
            cabang_id: jsonCabangId,
            kembalian_pservis: sumKembalian,
            hutang_pservis: sumHutang,
        };

        let payloadPembayaranServis = [];
        metodePembayaran.map((value) => {
            payloadPembayaranServis.push({
                kategori_pembayaran_id: value.kategori_pembayaran_selected.id,
                sub_pembayaran_id: value.sub_pembayaran_selected.id,
                bayar_pservis: value.bayar,
                deposit_pservis: value.jumlah_deposit,
                saldodeposit_pservis: value.jumlah_deposit,
                dibayaroleh_pservis:
                    value.dibayarkan_oleh === undefined
                        ? ""
                        : value.dibayarkan_oleh,
                users_id: value.user_selected.id,
                kembalian_pservis:
                    value.kembalian === "undefined" ? 0 : value.kembalian,
                hutang_pservis: value.hutang,
                nomorkartu_pservis:
                    value.nomor_kartu === undefined ? "" : value.nomor_kartu,
                pemilikkartu_pservis:
                    value.nama_pemilik_kartu === undefined
                        ? ""
                        : value.nama_pemilik_kartu,
                cabang_id: jsonCabangId,
            });
        });
        let payloadSaldoCustomer = {};
        const getFindDataKendaraan = jsonDataKendaraan.find(
            (item) => item.id == kendaraan_id
        );

        payloadSaldoCustomer = {
            saldo_customer_id: "",
            pembayaran_servis_id: "",
            totalsaldo_detail: sumDeposit,
            kembaliansaldo_detail: sumKembalian,
            hutangsaldo_detail: sumHutang,
            customer_id:
                getFindDataKendaraan != null
                    ? getFindDataKendaraan.customer_id
                    : "",
            cabang_id: jsonCabangId,
        };

        payloadEdit = {
            isEdit: isEdit,
            penerimaan_servis_id: penerimaanServisId,
        }

        return {
            payloadPenerimaanServis,
            payloadPembayaranServis,
            payloadSaldoCustomer,
            payloadEdit,
        };
    };
    // end pending

    body.off("click", ".popover.close");
    body.on("click", ".popover.close", function (e) {
        e.preventDefault();
        $("#btn-pop-over").popover("hide");
    });

    body.off("click", ".btn-confirm-bayar");
    body.on("click", ".btn-confirm-bayar", function (e) {
        e.preventDefault();
        const getPayloadKasir = payloadKasir();
        const getPenerimaanServis = getPayloadKasir.payloadPenerimaanServis;
        const error = formValidation(getPenerimaanServis);
        if (error) return;

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

                // tutup modal
                $("#btn-pop-over").popover("hide");

                // reset data
                resetData();
                refreshDataSet();
                myModal.hide();
                datatable.ajax.reload();
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
