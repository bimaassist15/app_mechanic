// "use strict";
var datatable;
var urlRoot = $(".url_root").data("value");
var setOrderBarang = [];

var cabangId = $(".cabang_id").data("value");
var usersId = $(".users_id").data("value");
var kodeTstock = $(".kode_tstock").data("value");
var getBarang = $(".barang").data("value");
var isEdit = $(".isEdit").data("value");
var idData = $(".id").data("value");

var renderListBarang = (data, isOnlyTotalHarga = false) => {
    let output = ``;
    const { result } = data;

    let no = 1;
    result.map((v) => {
        if (!isOnlyTotalHarga) {
            const checkFindIndex = setOrderBarang.findIndex(
                (item) => item.barang_id === v.barang_id
            );
            if (checkFindIndex == -1) {
                setOrderBarang.push({
                    barang_id: v.barang_id,
                    barcode_barang: v.barang_selected.barcode_barang,
                    nama_barang: v.barang_selected.nama_barang,
                    qty_tdetail: v.qty_tdetail,
                });
            }
        }

        if (!isOnlyTotalHarga) {
            output += `
 <tr>
     <td>${no++}</td>
     <td>${v.barang_selected.barcode_barang}</td>
     <td>${v.barang_selected.nama_barang}</td>
     <td>
        <input name="qty_tdetail" class="form-control" placeholder="Masukan data qty..." data-id="${
            v.barang_id
        }" value="${formatNumber(
                v.qty_tdetail
            )}" title="Stok Barang: ${formatNumber(
                v.barang_selected.stok_barang
            )}" />
    </td>
     <td>
         <a href="#" data-id="${v.barang_id}"
             class="btn btn-danger delete-order-barang btn-small"
             title="Delete Barang">
             <i class="fa-solid fa-trash"></i>
         </a>
     </td>
 </tr>
 `;
        }

        if (isOnlyTotalHarga) {
            $(`input[name="qty_tdetail"][data-id="${v.barang_id}" ]`).attr(
                "title",
                `Stok Barang: ${formatNumber(v.barang_selected.stok_barang)}`
            );
        }
    });
    if (!isOnlyTotalHarga) {
        $(".loadOrderBarang").html(output);
    }
};

var refreshData = () => {
    $.ajax({
        url: `${urlRoot}/transferStock/transaksi`,
        type: "get",
        data: {
            refresh: true,
        },
        dataType: "json",
        success: function (data) {
            cabangId = data.cabang_id;
            usersId = data.users_id;
            kodeTstock = data.kodeTStock;
            getBarang = data.barang;

            $(".output_kodeTStock").html(`
            Ref: ${kodeTstock}
            `);
        },
    });
};

var editData = () => {
    if (isEdit) {
        $.ajax({
            url: `${urlRoot}/transferStock/transaksi`,
            type: "get",
            data: {
                editData: true,
                isEdit,
                id: idData,
            },
            dataType: "json",
            success: function (data) {
                $('select[name="cabang_id_awal"]')
                    .val(data.cabang_id_awal)
                    .trigger("change");
                $('select[name="cabang_id_penerima"]')
                    .val(data.cabang_id_penerima)
                    .trigger("change");
                $('textarea[name="keterangan_tstock"]').val(
                    data.keterangan_tstock
                );

                const transfer_detail = data.transfer_detail;
                transfer_detail.map((v) => {
                    setOrderBarang.push({
                        barang_id: v.barang_id,
                        qty_tdetail: v.qty_tdetail,
                        cabang_id: cabangId,
                        barang_selected: v.barang,
                    });
                });

                renderListBarang({
                    result: setOrderBarang,
                });
            },
        });
    }
};

$(document).ready(function () {
    var body = $("body");
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='cabang_id_awal']",
    });
    select2Standard({
        parent: ".content-wrapper",
        selector: "select[name='cabang_id_penerima']",
    });

    const cabang_id_awal = $('select[name="cabang_id_awal"]').val();

    select2Server({
        selector: "select[name=barang_id]",
        parent: ".content-wrapper",
        routing: `${urlRoot}/select/barang`,
        passData: {
            cabang_id: cabang_id_awal || cabangId,
        },
    });

    const inputOrderBarang = (id) => {
        const qty_tdetail = $(
            `input[name="qty_tdetail"][data-id="${id}"]`
        ).val();

        return {
            qty_tdetail,
        };
    };

    const newOrderBarang = (id) => {
        const getInputOrderBarang = inputOrderBarang(id);

        // set by id data
        const getFindIndex = setOrderBarang.findIndex(
            (item) => item.barang_id == id
        );
        if (getFindIndex !== -1) {
            const dataOrderBarang = setOrderBarang[getFindIndex];

            dataOrderBarang.barang_id = id;
            dataOrderBarang.qty_tdetail = removeCommas(
                getInputOrderBarang.qty_tdetail
            );
        }
    };

    const handleDisplayInput = () => {
        setOrderBarang.map((vItem, iItem) => {
            $(`input[name="qty_tdetail"][data-id="${vItem.barang_id}"]`).val(
                formatNumber(vItem.qty_tdetail)
            );
        });
    };

    const checkBarangCabang = (payload) => {
        var output = false;
        $.ajax({
            url: `${urlRoot}/transferStock/transaksi/checkBarang`,
            type: "get",
            data: payload,
            dataType: "json",
            type: "get",
            async: false,
            success: function (data) {
                output = data;
            },
        });
        return output;
    };

    refreshData();
    editData();

    body.on("change", "select[name='barang_id']", function () {
        const value = $(this).val();
        const cabang_id_awal = $('select[name="cabang_id_awal"]').val();
        if (value == "-") {
            return;
        }

        if (cabang_id_awal === "") {
            return runToast({
                type: "bg-danger",
                description: "Cabang Pemberi wajib diisi",
                title: "Form Validation",
            });
        }

        const cabang_id_penerima = $('select[name="cabang_id_penerima"]').val();
        if (cabang_id_penerima === "") {
            return runToast({
                type: "bg-danger",
                description: "Cabang penerima wajib diisi",
                title: "Form Validation",
            });
        }
        const checkBarang = checkBarangCabang({
            cabang_id_penerima,
            barang_id: value,
        });
        if (!checkBarang.result) {
            return runToast({
                type: "bg-danger",
                description: checkBarang.message,
                title: "Form Validation",
            });
        }

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

            let jumlahDataBarang = parseFloat(getDataBarang.qty_tdetail);
            let jumlahDataBarangPlus = ++jumlahDataBarang;
            const stokDataBarang = getDataBarang.barang_selected.stok_barang;

            if (jumlahDataBarangPlus < 0) {
                jumlahDataBarangPlus = 0;
                getDataBarang.qty_tdetail = 0;
            }
            if (jumlahDataBarangPlus > stokDataBarang) {
                jumlahDataBarangPlus = jumlahDataBarang;
                getDataBarang.qty_tdetail = jumlahDataBarang;
                runToast({
                    type: "bg-danger",
                    description: `Barang: ${getDataBarang.barang_selected.nama_barang} melebihi stok barang`,
                });
            }

            getDataBarang.qty_tdetail = jumlahDataBarangPlus;

            $(
                `input[name="qty_tdetail"][data-id="${getDataBarang.barang_id}"]`
            ).val(formatNumber(jumlahDataBarangPlus));

            newOrderBarang(getDataBarang.barang_id);

            handleDisplayInput();
        } else {
            const getFindData = getBarang.find((item) => item.id == value);
            if (getFindData) {
                setOrderBarang.push({
                    barang_id: getFindData.id,
                    qty_tdetail: 1,
                    cabang_id: cabangId,
                    barang_selected: getFindData,
                });

                renderListBarang({
                    result: setOrderBarang,
                });
            }
        }
    });

    body.on("click", ".delete-order-barang", function (e) {
        e.preventDefault();
        const id = $(this).data("id");
        const getFindIndex = setOrderBarang.findIndex(
            (item) => item.barang_id == id
        );

        if (getFindIndex !== -1) {
            setOrderBarang.splice(getFindIndex, 1);
            renderListBarang({
                result: setOrderBarang,
            });
        }
    });

    body.on("input", "input[name='qty_tdetail']", function () {
        const id = $(this).data("id");
        const getValueInput = $(
            `input[name="qty_tdetail"][data-id="${id}"]`
        ).val();
        if (getValueInput == "") {
            return;
        }

        const qtyValue = parseFloat(removeCommas($(this).val()));

        // check awal
        const getFindIndex = setOrderBarang.findIndex(
            (item) => item.barang_id == id
        );

        if (getFindIndex !== -1) {
            const dataOrderBarang = setOrderBarang[getFindIndex];

            if (qtyValue < 0) {
                $(this).val(0);
            }
            if (qtyValue > dataOrderBarang.barang_selected.stok_barang) {
                $(this).val(0);
                runToast({
                    type: "bg-danger",
                    description: `Barang: ${dataOrderBarang.barang_selected.nama_barang} melebihi stok barang`,
                });
            }
        }

        newOrderBarang(id);

        const value = formatNumber($(this).val());
        $(this).val(value);

        // update display input
        handleDisplayInput();
    });

    const formValidation = () => {
        const cabang_id_awal = $('select[name="cabang_id_awal"]').val();
        const cabang_id_penerima = $('select[name="cabang_id_penerima"]').val();
        const lengthSetOrderBarang = setOrderBarang.length;

        let errorValidation = [];
        if (cabang_id_awal === "") {
            errorValidation.push("Cabang awal wajib diisi");
        }

        if (cabang_id_penerima === "") {
            errorValidation.push("Cabang penerima wajib diisi");
        }

        if (lengthSetOrderBarang == 0) {
            errorValidation.push("Barang wajib diisi");
        }

        let isQtyZero = false;
        setOrderBarang.map((vItem, iItem) => {
            if (vItem.qty_tdetail == 0) {
                isQtyZero = true;
            }
        });

        if (isQtyZero) {
            errorValidation.push("Qty barang tidak boleh 0");
        }

        if (cabang_id_awal == cabang_id_penerima) {
            errorValidation.push("Cabang awal dan penerima tidak boleh sama");
        }

        return errorValidation;
    };

    const payloadSubmit = () => {
        const cabang_id_awal = $('select[name="cabang_id_awal"]').val();
        const cabang_id_penerima = $('select[name="cabang_id_penerima"]').val();

        const payload = {
            kode_tstock: kodeTstock,
            cabang_id_awal,
            cabang_id_penerima,
            cabang_id: cabangId,
            users_id: usersId,
            keterangan_tstock: $('textarea[name="keterangan_tstock"]').val(),
            status_tstock: "proses kirim",
            tanggalkirim_tstock: formatDatePayload(),
            tanggalditerima_tstock: "",
        };

        const payloadDetail = [];
        setOrderBarang.map((vItem, iItem) => {
            payloadDetail.push({
                transfer_stock_id: "",
                barang_id: vItem.barang_id,
                qty_tdetail: vItem.qty_tdetail,
                cabang_id: cabangId,
            });
        });

        return {
            transfer_stock: payload,
            transfer_detail: payloadDetail,
            transfer_edit: {
                isEdit,
                id: idData,
            },
        };
    };

    const resetForm = () => {
        setOrderBarang = [];
        renderListBarang({
            result: setOrderBarang,
        });
        $('select[name="cabang_id_awal"]').val("");
        $('select[name="cabang_id_penerima"]').val("");
        $('textarea[name="keterangan_tstock"]').val("");
    };

    body.on("click", ".btn-submit", function (e) {
        e.preventDefault();
        const errorValidation = formValidation();
        let message = ``;
        errorValidation.map((v) => {
            message += v + "<br>";
        });
        if (message != "") {
            return runToast({
                title: "Form Validation",
                description: message,
                type: "bg-danger",
            });
        }

        // next proses
        const payload = payloadSubmit();

        $.ajax({
            url: `${urlRoot}/transferStock/transaksi/transferBarang`,
            type: "post",
            data: payload,
            dataType: "json",
            beforeSend: function () {
                $(".btn-submit").attr("disabled", true);
                $(".btn-submit").html(disableButton);
            },
            success: function (data) {
                runToast({
                    title: "Successfully",
                    description: data,
                    type: "bg-success",
                });
                resetForm();
                refreshData();

                if (isEdit) {
                    window.location.href = `${urlRoot}/transferStock/keluar`;
                }
            },
            complete: function () {
                $(".btn-submit").attr("disabled", false);
                $(".btn-submit").html(`
                    <span>
                        <i class="fa-regular fa-paper-plane"></i>
                        Transfer Sekarang
                    </span>
                `);
            },
        });
    });

    body.on("change", 'select[name="cabang_id_awal"]', function () {
        const cabang_id_awal = $(this).val();

        select2Server({
            selector: "select[name=barang_id]",
            parent: ".content-wrapper",
            routing: `${urlRoot}/select/barang`,
            passData: {
                cabang_id: cabang_id_awal,
            },
        });
    });
});
