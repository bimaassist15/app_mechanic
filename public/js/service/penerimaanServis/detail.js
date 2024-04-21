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

var statusPservis = "";
var urlRoot = $(".url_root").data("url");

select2Standard({
    parent: ".content-wrapper",
    selector: "select[name='status_pservis']",
});

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
            const result = data.data.row.order_barang;
            const serviceHistory = data.data.row.service_history;
            jsonServiceHistory = serviceHistory;
            statusPservis = data.data.row.status_pservis;;

            result.map(v => {
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
        },
        complete: function(){
            $('#load_viewdata').addClass("d-none");
        }
    })
}

const viewServiceHistori = () => {
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
            
            $('.output_informasi_servis').html('');

        },
        data: {
            loadDataServis: true,
        },
        success: function(data){
            $('.output_data_servis').html(data.order_servis);
            $('.output_informasi_servis').html(data.informasi_servis);
        },
        complete: function(){
            $('#load_viewdata_orderservis').addClass('d-none');
            $('#load_output_informasi_servis').addClass('d-none');
        }
    })
}

const viewRenderSparepart = () => {
    $.ajax({
        url: `${urlRoot}/service/outputUpdateService/${jsonPenerimaanServisId}`,
        type: 'get',
        dataType: 'json',
        beforeSend: function(){
            $('#load_viewdata_order_barang').removeClass('d-none');
            $('#load_output_informasi_servis').removeClass('d-none');
            
            $('.output_informasi_servis').html('');

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
        },
        complete: function(){
            $('#load_viewdata_order_barang').addClass('d-none');
            $('#load_output_informasi_servis').addClass('d-none');
        }
    })
}

var setOrderBarang = [];
$(document).ready(function () {
    viewRender();
    
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
            url: $(".url_order_servis").data("url"),
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
            urlDelete: $(this).attr("href"),
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
            urlDelete: $(this).attr("href"),
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

    body.on("click", ".btn-submit-data", function (e) {
        e.preventDefault();
        if (statusPservis == "estimasi servis") {
            $.ajax({
                url: `${urlRoot}/service/estimasiServis/${jsonPenerimaanServisId}/nextProcess`,
                type: "post",
                dataType: "json",
            });
        }

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
                    viewRenderSparepart();
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

    const printOutput = (output) => {
        var printWindow = window.open("", "_blank");
        printWindow.document.write(output);
        printWindow.document.close();
        printWindow.print();
        printWindow.close();
    };

    body.on("click", ".btn-print-data", function (e) {
        e.preventDefault();
        const output = renderPrintKasir();
        printOutput(output);
    });   
});
