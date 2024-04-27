select2Server({
    selector: "select[name=harga_servis_id]",
    parent: ".content-wrapper",
    routing: `${urlRoot}/select/hargaServis`,
    passData: {},
});

select2Server({
    selector: "select[name=barang_id]",
    parent: ".content-wrapper",
    routing: `${urlRoot}/select/barang`,
    passData: {
        status_barang: "dijual & untuk servis, khusus servis",
    },
});

select2Standard({
    parent: ".content-wrapper",
    selector: "select[name='status_pservis']",
});

select2Standard({
    parent: ".content-wrapper",
    selector: "select[name='kategori_pembayaran_id']",
});

select2Standard({
    parent: ".content-wrapper",
    selector: "select[name='tipeberkala_pservis']",
});