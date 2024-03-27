// "use strict";
var datatable;
var myModal;
var urlRoot = $(".url_root").data("url");
var public_path = $(".public_path").data("value");

$(document).ready(function () {
    function initDatatable() {
        datatable = basicDatatable({
            tableId: $("#dataTable"),
            ajaxUrl: $(".url_datatable").data("url"),
            columns: [
                {
                    data: null,
                    orderable: false,
                    searchable: false,
                    className: "text-center",
                },
                {
                    data: "nonota_pservis",
                    name: "nonota_pservis",
                    searchable: true,
                },
                {
                    data: "noantrian_pservis",
                    name: "noantrian_pservis",
                    searchable: true,
                },
                {
                    data: "kendaraan.customer.nama_customer",
                    name: "kendaraan.customer.nama_customer",
                    searchable: true,
                },
                {
                    data: "created_at",
                    name: "created_at",
                    searchable: true,
                },
                {
                    data: "status_pservis",
                    name: "status_pservis",
                    searchable: true,
                },
                {
                    data: "totalbiaya_pservis",
                    name: "totalbiaya_pservis",
                    searchable: true,
                },
                {
                    data: "action",
                    name: "action",
                    searchable: false,
                    orderable: false,
                },
            ],
            dataAjaxUrl: {},
        });
    }
    initDatatable();

    var body = $("body");
    const checkFile = (data) => {
        var output = "";
        $.ajax({
            url: `${urlRoot}/service/checkFile`,
            dataType: "json",
            data: {
                no_antrian: JSON.stringify(data),
            },
            type: "post",
            async: false,
            success: function (data) {
                output = data;
            },
        });

        return output;
    };
    body.on("click", ".btn-call", function (e) {
        e.preventDefault();
        let setAntrian = [];
        const setPath = `${public_path}antrian`;
        const tingtung = `${setPath}/tingtung.mp3`;
        const nomor_antrian = `${setPath}/nomor_antrian.wav`;
        const segera_menuju_kasir = `${setPath}/segera_menuju_kasir.wav`;
        setAntrian.push(tingtung);
        setAntrian.push(nomor_antrian);

        const getNoAntrian = $(this).data("noantrian");
        let antrian = angkaKeTeks(getNoAntrian);
        const splitAntrian = antrian.split(" ");
        let pushNoAntrian = [];
        splitAntrian.map((v) => {
            pushNoAntrian.push(v);
        });
        const checkData = JSON.parse(checkFile(pushNoAntrian));
        checkData.map((v) => {
            setAntrian.push(`${setPath}/${v}`);
        });

        setAntrian.push(segera_menuju_kasir);

        playAudioSequentially(setAntrian)
            .then(() => {
                console.log("Semua audio dangdut telah diputar.");
            })
            .catch((error) => {
                console.error("Terjadi kesalahan:", error);
            });
    });
});
