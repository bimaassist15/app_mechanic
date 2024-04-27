// "use strict";
var datatable;
var myModal;

// penerimaan servis
var jsonUsersId = '';
var jsonPenerimaanServisId = $('.penerimaanServisId').data('value');
var jsonGetServis = '';
var jsonGetBarang = '';
var jsonTipeDiskon = '';
var jsonCabangId = '';
var jsonServiceHistory = [];
// end penerimaan servis

// pengembalian servis
var jsonKategoriPembayaran = '';
var jsonArrayKategoriPembayaran = '';
var jsonSubPembayaran = '';
var jsonArraySubPembayaran = '';
var jsonDataUser = '';
var jsonCabangId = '';
var row = '';

var jsonDefaultUser = '';
var is_deposit = '';
var getPembayaranServis = '';

var metodePembayaran = [];
var totalHargaItems = '';
var saldoDepositCustomer = '';
var customerId = '';
// end pengembalian servis

var statusPservis = "";
var urlRoot = $(".url_root").data("url");
var allowedPservis = ['sudah diambil', 'komplain garansi'];


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
                        metodePembayaran[findDataIndex].sisasaldo_deposit;
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

const handeMetodePembayaran = (index) => {
    const checkMetodePembayaran =
        metodePembayaran[index].kategori_pembayaran_selected;
    let kategori_pembayaran_id = checkMetodePembayaran.id;
    let sub_pembayaran_id =
        metodePembayaran[index].sub_pembayaran_selected &&
        metodePembayaran[index].sub_pembayaran_selected.id;

    if (
        checkMetodePembayaran.nama_kpembayaran.toLowerCase() !== "deposit"
    ) {
        kategori_pembayaran_id = $(
            `select[name="kategori_pembayaran_id_mp"][data-index="${index}"]`
        ).val();
        sub_pembayaran_id = $(
            `select[name="sub_pembayaran_id_mp"][data-index="${index}"]`
        ).val();
    }

    let users_id = $(`select[name="akun"][data-index="${index}"]`).val();
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
                    <select data-index="${index}" name="kategori_pembayaran_id_mp" class="form-control" ${ allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
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
            <div class="col-lg-6">`;
            if(!allowedPservis.includes(statusPservis)){
                output += `
                    <button class="btn btn-delete-pembayaran" title="Hapus item" data-index="${index}">
                    <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i>
                    </button>
                `;
            }
            output += `
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-4">
                <div class="form-group">
                    <select data-index="${index}" name="sub_pembayaran_id_mp" class="form-control" ${allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
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
                        )}" ${allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
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
                        }" ${allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-4">
                <div class="form-group">
                    <label for="">Akun</label>
                    <select name="akun" class="form-control"
                    data-index="${index}" ${ allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
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
                    name="kategori_pembayaran_id_mp" id="" class="form-control" ${allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
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
            <div class="col-lg-6">`;
            if(!allowedPservis.includes(statusPservis)){
                output += `
                <button class="btn btn-delete-pembayaran" title="Hapus item" data-index="${index}">
                    <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i>
                </button>
                `;
            }
            output += `
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-4">
                <div class="form-group">
                    <select name="sub_pembayaran_id_mp" data-index="${index}"
                    class="form-control" ${allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
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
                    data-index="${index}" ${allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
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
                    value="${number_format(value.bayar, 0, ".", ",")}"
                    ${allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
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
                        <div class="col-lg-4">`;

                        if(!allowedPservis.includes(statusPservis)){
                        output += `
                            <button class="btn btn-delete-pembayaran" title="Hapus item" data-index="${index}">
                                <i class="fa-solid fa-circle-xmark fa-2x text-danger"></i>
                            </button>`;
                        }


                        output += `
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
                            )}" ${allowedPservis.includes(statusPservis) ? 'disabled' : ''}>
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
const afterPayService = () => {
    const pembayaran_servis = row.pembayaran_servis;
    const indexTarget = pembayaran_servis.findIndex(item => item.kategori_pembayaran.nama_kpembayaran.toLowerCase() === 'deposit');
    let dataPembayaran = [];
    if(indexTarget !== -1){
        dataPembayaran = pembayaran_servis.filter((data, index) => index >= indexTarget);
    } else {
        dataPembayaran = pembayaran_servis;
    }
    
    if(dataPembayaran.length > 0 && allowedPservis.includes(statusPservis)){
        let pushMetodePembayaran = [];
        metodePembayaran = [];
        dataPembayaran.map((value, index) => {
            const getKategoriPembayaran = jsonKategoriPembayaran.find(
                (item) => item.nama_kpembayaran.toLowerCase() == value.kategori_pembayaran.nama_kpembayaran.toLowerCase(),
            );
        
            const getSubPembayaran = jsonSubPembayaran.find(
                (item) =>
                    item.kategori_pembayaran_id == getKategoriPembayaran.id
            );
            const userSelected = jsonDataUser.find(
                (item) => item.id == jsonDefaultUser
            );

            const saldoDeposit = value.saldodeposit_pservis;

            let dataMetodePembayaran = {};
            dataMetodePembayaran.kategori_pembayaran = jsonKategoriPembayaran;
            dataMetodePembayaran.kategori_pembayaran_selected =
                getKategoriPembayaran;
            dataMetodePembayaran.sub_pembayaran = jsonSubPembayaran;
            dataMetodePembayaran.sub_pembayaran_selected = getSubPembayaran;
            dataMetodePembayaran.user = jsonDataUser;
            dataMetodePembayaran.user_selected = userSelected;
            dataMetodePembayaran.bayar = value.bayar_pservis;
            dataMetodePembayaran.dibayarkan_oleh = value.dibayaroleh_pservis;
            dataMetodePembayaran.kembalian = value.kembalian_pservis;
            dataMetodePembayaran.hutang = value.hutang_pservis;
            dataMetodePembayaran.nomor_kartu = "";
            dataMetodePembayaran.nama_pemilik_kartu = "";
            dataMetodePembayaran.saldo_deposit = saldoDeposit;
            dataMetodePembayaran.sisasaldo_deposit = saldoDeposit - value.bayar_pservis;
            dataMetodePembayaran.index = index;

            pushMetodePembayaran.push(dataMetodePembayaran);
        });

        metodePembayaran = pushMetodePembayaran;
        const output = viewMetodePembayaran();
        $(".output_metode_pembayaran").html(output); 
    }
}

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

const viewRender = () => {
    $.ajax({
        url: `${urlRoot}/service/penerimaanServis/${jsonPenerimaanServisId}`,
        type: 'get',
        dataType: 'json',
        data: {
            loadData: true,
        },
        beforeSend: function(){
            $('#load_viewdata').removeClass("d-none");
        },
        success: function(data){
            // penerimaan servis
            const orderBarang = data.data.row.order_barang;
            const rowData = data.data.row;
            const getData = data.data;

            const serviceHistory = rowData.service_history;
            jsonServiceHistory = serviceHistory;
            statusPservis = rowData.status_pservis;
            jsonUsersId = getData.usersId;
            jsonGetServis = getData.getServis;
            jsonGetBarang = getData.barang;
            jsonTipeDiskon = getData.tipeDiskon;
            jsonCabangId = getData.cabangId;

            orderBarang.map(v => {
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
            })
            $('#output_data').html(data.view);
            // end penerimaan servis

            // pengembalian servis
            jsonKategoriPembayaran = JSON.parse(getData.kategoriPembayaran);
            jsonArrayKategoriPembayaran = JSON.parse(getData.array_kategori_pembayaran);
            jsonSubPembayaran = JSON.parse(getData.subPembayaran);
            jsonArraySubPembayaran = JSON.parse(getData.array_sub_pembayaran);
            jsonDataUser = JSON.parse(getData.dataUser);
            row = rowData;

            jsonDefaultUser = getData.defaultUser;
            is_deposit = getData.is_deposit;
            getPembayaranServis = JSON.parse(getData.getPembayaranServis);

            metodePembayaran = [];
            totalHargaItems = getPembayaranServis.hutang;
            saldoDepositCustomer = rowData.customer.saldo_customer.jumlah_saldocustomer;
            customerId = rowData.customer.id;
            if(is_deposit){
                renderDeposit();
            }
            // jika sudah melakukan pembayaran
            afterPayService();
            // end pengembalian servis

        },
        complete: function(){
            $('#load_viewdata').addClass("d-none");
        }
    })
}

const viewRenderHistori = () => {
    $.ajax({
        url: `${urlRoot}/service/outputUpdateService/${jsonPenerimaanServisId}`,
        type: 'get',
        dataType: 'json',
        beforeSend: function(){
            $('#load_view_data_history').removeClass('d-none');
        },
        data: {
            loadDataHistory: true,
        },
        success: function(data){
            $('.output_data_history').html(data.service_history);
        },
        complete: function(){
            $('#load_view_data_history').addClass('d-none');
        }
    })
}

const viewRenderServis = () => {
    $.ajax({
        url: `${urlRoot}/service/outputUpdateService/${jsonPenerimaanServisId}`,
        type: 'get',
        dataType: 'json',
        beforeSend: function(){
            $('#load_viewdata_orderservis').removeClass('d-none');
            $('#load_output_informasi_servis').removeClass('d-none');
        },
        data: {
            loadDataServis: true,
        },
        success: function(data){
            $('.output_data_servis').html(data.order_servis);
            $('.output_informasi_servis').html(data.informasi_servis);
            select2Standard({
                parent: ".content-wrapper",
                selector: "select[name='status_pservis']",
            });
            select2Standard({
                parent: ".content-wrapper",
                selector: "select[name='kategori_pembayaran_id']",
            });

            const rowData = data.row;
            const getPembayaranServis = JSON.parse(data.getPembayaranServis);
            if(data.row.status_pservis === 'bisa diambil'){
                const is_deposit = rowData.isdp_pservis;
                if(is_deposit){
                    metodePembayaran = [];
                    totalHargaItems = getPembayaranServis.hutang;
                    saldoDepositCustomer = rowData.customer.saldo_customer.jumlah_saldocustomer;
                    renderDeposit();
                }
            }
            
        },
        complete: function(){
            $('#load_viewdata_orderservis').addClass('d-none');
            $('#load_output_informasi_servis').addClass('d-none');
        }
    })
}

const viewRenderSparepart = (is_deposit = false) => {
    $.ajax({
        url: `${urlRoot}/service/outputUpdateService/${jsonPenerimaanServisId}`,
        type: 'get',
        dataType: 'json',
        beforeSend: function(){
            $('#load_viewdata_order_barang').removeClass('d-none');
            $('#load_output_informasi_servis').removeClass('d-none');
        },
        data: {
            loadDataSparepart: true,
        },
        success: function(data){
            $('.output_order_barang').html(data.order_barang);
            $('.output_informasi_servis').html(data.informasi_servis);

            const result = data.row.order_barang;
            result.map(v => {
                const searchData = setOrderBarang.findIndex(item => item.id === v.id);
                if(searchData === -1){
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
            })
            select2Standard({
                parent: ".content-wrapper",
                selector: "select[name='status_pservis']",
            });
            select2Standard({
                parent: ".content-wrapper",
                selector: "select[name='kategori_pembayaran_id']",
            });

            const rowData = data.row;
            const getPembayaranServis = JSON.parse(data.getPembayaranServis);
            if(data.row.status_pservis === 'bisa diambil'){
                const is_deposit = rowData.isdp_pservis;
                if(is_deposit){
                    metodePembayaran = [];
                    totalHargaItems = getPembayaranServis.hutang;
                    saldoDepositCustomer = rowData.customer.saldo_customer.jumlah_saldocustomer;
                    renderDeposit();
                }
            }
        },
        complete: function(){
            $('#load_viewdata_order_barang').addClass('d-none');
            $('#load_output_informasi_servis').addClass('d-none');
        }
    })
}

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

var setOrderBarang = [];
$(document).ready(function () {
    viewRender();
    handleButtonBayar();
    
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
            url: `${urlRoot}/service/orderServis`,
            type: "post",
            dataType: "json",
            data: payload,
            success: function (data) {
                viewRenderServis();
            },
        });        
    });

    body.on("click", ".delete-order-servis", function (e) {
        e.preventDefault();

        basicDeleteConfirmDatatable({
            urlDelete: $(this).data("urlcreate"),
            data: {
                penerimaan_servis_id: jsonPenerimaanServisId,
            },
            text: "Apakah anda yakin ingin menghapus item ini?",
            dataFunction: viewRenderServis,
            isRenderView: true,
        });
    });

    body.on("click", ".update-users-mekanik", function (e) {
        e.preventDefault();

        showModal({
            url: $(this).data("urlcreate"),
            modalId: $(this).data("typemodal"),
            title: "Form Pilih Mekanik",
            type: "get",
            renderData: viewRenderServis
        });
    });

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

            let jumlahDataBarang = parseFloat(getDataBarang.qty_orderbarang);
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
                viewRenderSparepart();
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
                viewRenderSparepart();
            
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
            $(`input[name="diskon_orderbarang"][data-id="${vItem.id}"]`).val(
                formatNumber(vItem.diskon_orderbarang)
            );
            $(`.output_subtotal_orderbarang[data-id="${vItem.id}"]`).html(
                formatNumber(vItem.subtotal_orderbarang)
            );
        });
    };

    const handleDisplayInputMetodePembayaran = () => {
        metodePembayaran.map((value, index) => {
            $(
                `select[name="kategori_pembayaran_id_mp"][data-index="${index}"]`
            ).val(value.kategori_pembayaran_selected.id);
            $(`select[name="sub_pembayaran_id_mp"][data-index="${index}"]`).val(
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
            $(`input[name="nama_pemilik_kartu"][data-index="${index}"]`).val(
                value.nama_pemilik_kartu
            );
        });
    };

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
            urlDelete: $(this).data("urlcreate"),
            data: {
                penerimaan_servis_id: jsonPenerimaanServisId,
            },
            text: "Apakah anda yakin ingin menghapus item ini?",
            dataFunction: viewRenderSparepart,
            isRenderView: true,
        });
    });

    body.on("click", ".btn-remember-estimasi", function (e) {
        e.preventDefault();
        const url = $(this).attr("href");
        Swal.fire({
            title: "Konfirmasi",
            text: "Apakah anda yakin ingin mengingatkan estimasi servis ini?",
            icon: "warning",
            dangerMode: true,
            showCancelButton: true,
            confirmButtonText: "Ya, hapus",
            cancelButtonText: "Tidak",
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url,
                    type: "post",
                    dataType: "json",
                    success: function (data) {
                        if (data.status == "success") {
                            runToast({
                                type: "bg-success",
                                title: "Berhasil Mengingatkan",
                                message:
                                    "Estimasi servis berhasil diingatkan ke customer",
                            });

                            window.open(data.message, "_blank");
                            viewRender();
                        }
                    },
                });
            }
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

    const validateFormPenerimaan = () => {
        let error = false;
        const payload = payloadSubmit();

        const lastStatus = jsonServiceHistory.length - 1;
        const getLastStatus = jsonServiceHistory[lastStatus].status_histori;
        if (getLastStatus == payload.status_pservis && statusPservis !== 'bisa diambil') {
            error = true;
            runToast({
                type: "bg-danger",
                title: "Form Validation",
                description:
                    "Status servis anda terakhir sama dengan status servis anda yang baru",
            });
        }

        let getValueStatus = $('select[name="status_pservis"]').val();
        if(statusPservis == 'bisa diambil'){
            getValueStatus = statusPservis;
        }

        const statusAllowed = ["bisa diambil"];
        const fieldStatusAmbil =
            (payload.nilaiberkala_pservis == "" &&
                payload.tipeberkala_pservis != "") ||
            (payload.nilaiberkala_pservis != "" &&
                payload.tipeberkala_pservis == "") ||
            (payload.nilaiberkala_pservis == "" &&
                payload.tipeberkala_pservis == "");

        if (fieldStatusAmbil && statusAllowed.includes(getValueStatus)) {
            error = true;
            runToast({
                type: "bg-danger",
                title: "Form Validation",
                description:
                    "Wajib mengisi nilai berkala, dan wajib mengisi tipe servis berkala",
            });
        }

        return error;
    }

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
                kategori_pembayaran_id: item.kategori_pembayaran_selected.id,
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

    const validateFormPengembalian = () => {
        let error = false;
        const nilaigaransi_pservis = $(
            'input[name="nilaigaransi_pservis"]'
        ).val();
        const tipegaransi_pservis = $(
            'select[name="tipegaransi_pservis"]'
        ).val();

        if (nilaigaransi_pservis === "" && tipegaransi_pservis !== "") {
            error = true;
            runToast({
                type: "bg-danger",
                title: "Form Validation",
                description:
                    "Jumlah servis garansi atau jenis harian wajib diisi",
            });
        }
        if (nilaigaransi_pservis !== "" && tipegaransi_pservis === "") {
            error = true;
            runToast({
                type: "bg-danger",
                title: "Form Validation",
                description:
                    "Jumlah servis garansi atau jenis harian wajib diisi",
            });
        }
        if (nilaigaransi_pservis === "" && tipegaransi_pservis === "") {
            error = true;
            runToast({
                type: "bg-danger",
                title: "Form Validation",
                description:
                    "Jumlah servis garansi atau jenis harian wajib diisi",
            });
        }

        return error;
    };

    body.on("click", ".btn-submit-data", function (e) {
        e.preventDefault();        
        if (statusPservis == "estimasi servis") {
            $.ajax({
                url: `${urlRoot}/service/estimasiServis/${jsonPenerimaanServisId}/nextProcess`,
                type: "post",
                dataType: "json",
            });
            viewRender();
        }

        if(allowedPservis.includes(statusPservis)){
            const garansi_pservis = $('textarea[name="garansi_pservis"]').val();
            $.ajax({
                url: `${urlRoot}/service/garansi/${jsonPenerimaanServisId}/update?_method=put`,
                type: "post",
                data: {
                    garansi_pservis: garansi_pservis,
                },
                dataType: "json",
                beforeSend: function(){
                    clearError422();
                    $(".btn-submit-data").attr("disabled", true);
                    $(".btn-submit-data").html(disableButton);
                },
                success: function(data){
                    if(data.status == 'error'){
                        runToast({
                            title: 'Failed',
                            type: 'bg-danger',
                            description: data.message,
                        })
                    }

                    if(data.status == 'success'){
                        runToast({
                            title: 'Successfully',
                            type: 'bg-success',
                            description: data.message,
                        })
                    }
                },
                error: function (jqXHR, exception) {
                    $(".btn-submit-data").attr("disabled", false);
                    $(".btn-submit-data").html(enableButton);
                    if (jqXHR.status === 422) {
                        showErrors422(jqXHR);
                    }
                },
                complete: function(){
                    $(".btn-submit-data").attr("disabled", false);
                    $(".btn-submit-data").html(enableButton);
                }
            });
            viewRender();
            return;
        }

        const error = validateFormPenerimaan();
        if(error) return;

        let payload = payloadSubmit();
        const allowedPengembalian = ['bisa diambil'];
        if(allowedPengembalian.includes(statusPservis)){
            const errorPengembalian = validateFormPengembalian();
            if(errorPengembalian) return;

            const dataPayloadPengembalian = payloadPengembalian();
            payload.is_pengembalian_servis = true;
            payload.status_pservis = 'sudah diambil';
            payload.pengembalian_servis = dataPayloadPengembalian;
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
                    const rowData = data.row;
                    runToast({
                        title: "Successfully",
                        description: data.message,
                        type: "bg-success",
                    });
                    const allowedPengembalian = ['bisa diambil'];
                    viewRenderHistori();
                    const booleanStatusPServis = allowedPengembalian.includes(statusPservis);
                    if(!booleanStatusPServis){
                        const is_deposit = rowData.isdp_pservis;
                        metodePembayaran = [];

                        getPembayaranServis = data.getPembayaranServis
                        saldoDepositCustomer = rowData.customer.saldo_customer.jumlah_saldocustomer;

                        viewRenderSparepart(is_deposit);
                    }
                    statusPservis = data.row.status_pservis;
                    jsonServiceHistory = data.row.service_history;

                    if(allowedPservis.includes(statusPservis)){
                        viewRender();
                    }
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

        submitAjaxData();
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
    
    const renderPrintKasirCompleted = () => {
        var output = "";
        $.ajax({
            url: `${urlRoot}/service/print/kendaraan/selesaiServis`,
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

    body.on("click", ".btn-print-data", function (e) {
        e.preventDefault();
        let tipe = $(this).data('tipe');
        tipe = tipe.trim();

        if(tipe == 'selesai'){
            const output = renderPrintKasirCompleted();
            printOutput(output);
        } else {
            const output = renderPrintKasir();
            printOutput(output);
        }
    });

    // pengembalian
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
        handleIndexArray();
        handleManageDeposit();
        handleManageHutang();
        handleDisplayInputMetodePembayaran();
        handleButtonBayar();
        const output = viewMetodePembayaran();
        $(".output_metode_pembayaran").html(output);
    });

    body.on("input", 'input[name="bayar"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageDeposit();
        handleManageHutang();
        handleDisplayInputMetodePembayaran();
        handleButtonBayar();
    });

    body.on("change", 'select[name="kategori_pembayaran_id_mp"]', function () {
        const index = $(this).data("index");
        const value = $(this).val();
        if (value !== null && value !== "") {
            handeMetodePembayaran(index);
            handleAnotherMethodLangsung();
            handleManageDeposit();
            handleManageHutang();
            handleDisplayInputMetodePembayaran();
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
        handleManageDeposit();
        handleManageHutang();
        handleDisplayInputMetodePembayaran();
        handleButtonBayar();
    });

    body.on("input", 'input[name="nomor_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageDeposit();
        handleManageHutang();
        handleDisplayInputMetodePembayaran();
        handleButtonBayar();
    });

    body.on("input", 'input[name="nama_pemilik_kartu"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageDeposit();
        handleManageHutang();
        handleDisplayInputMetodePembayaran();
        handleButtonBayar();
    });

    body.on("change", 'select[name="akun"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageDeposit();
        handleManageHutang();
        handleDisplayInputMetodePembayaran();
        handleButtonBayar();
    });

    body.on("input", 'input[name="dibayar_oleh"]', function () {
        const index = $(this).data("index");
        handeMetodePembayaran(index);
        handleAnotherMethodLangsung();
        handleManageDeposit();
        handleManageHutang();
        handleDisplayInputMetodePembayaran();
        handleButtonBayar();
    });
});
