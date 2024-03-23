var jsonDataDetail = $(".data_detail").data("value");
var tableKendaraan;
var tablePembelian;
var jsonDataPayment = $(".data_payment").data("value");
var body = $("body");
$(document).ready(function () {
    // tabel kendaraan
    tableKendaraan = $("#dataTableKendaraan").DataTable();

    function format(id) {
        const getFindData = jsonDataDetail.kendaraan;
        const findData = getFindData.find((item) => item.id == id);

        var dateString = findData.created_at;
        var createdAt = formatDateFromDb(dateString);

        return `<table class="table">
                <tr>
                    <td>
                        <table class="w-100">
                            <tr>
                                <td>Nama Customer</td>
                                <td>:</td>
                                <td>${findData.customer.nama_customer}</td>
                            </tr>
                            <tr>
                                <td>No. Polisi</td>
                                <td>:</td>
                                <td>${findData.nopol_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>Merek</td>
                                <td>:</td>
                                <td>${findData.merek_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>Tipe</td>
                                <td>:</td>
                                <td>${findData.tipe_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>Jenis</td>
                                <td>:</td>
                                <td>${findData.jenis_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>Tahun Buat</td>
                                <td>:</td>
                                <td>${findData.tahunbuat_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>Tahun Rakit</td>
                                <td>:</td>
                                <td>${findData.tahunrakit_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>Silinder</td>
                                <td>:</td>
                                <td>${findData.silinder_kendaraan}</td>
                            </tr>
                        </table>
                    </td>
                    <td style="vertical-align: top;">
                        <table class="w-100">
                            <tr>
                                <td>Warna</td>
                                <td>:</td>
                                <td>${findData.warna_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>No. Rangka</td>
                                <td>:</td>
                                <td>${findData.norangka_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>No. Mesin</td>
                                <td>:</td>
                                <td>${findData.nomesin_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>Keterangan</td>
                                <td>:</td>
                                <td>${findData.keterangan_kendaraan}</td>
                            </tr>
                            <tr>
                                <td>Waktu Register</td>
                                <td>:</td>
                                <td>${createdAt}</td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>`;
    }

    body.off("click", ".detail-kendaraan");
    body.on("click", ".detail-kendaraan", function (e) {
        e.preventDefault();
        const show = $(this).data("show");
        if (show === 1) {
            $(this).data("show", 0);
            $(this).html('<i class="fa-solid fa-eye-slash"></i>');
        } else {
            $(this).data("show", 1);
            $(this).html('<i class="fa-solid fa-eye"></i>');
        }
    });

    body.off("click", "td a.detail-kendaraan");
    $("#dataTableKendaraan tbody").on(
        "click",
        "td a.detail-kendaraan",
        function () {
            var tr = $(this).closest("tr");
            var row = tableKendaraan.row(tr);
            var id = $(this).data("id");

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass("shown");
            } else {
                // Open this row
                row.child(format(id)).show();
                tr.addClass("shown");
            }
        }
    );

    // tabel pembelian
    tablePembelian = $("#dataTablePembelian").DataTable();

    function formatPembelian(id) {
        const getFindData = jsonDataDetail.penjualan;
        const findData = getFindData.find((item) => item.id == id);

        const penjualan_product = findData.penjualan_product;
        const penjualan_pembayaran = findData.penjualan_pembayaran;
        const searchPayment = jsonDataPayment.find((item) => item.id == id);

        console.log("get search payment", searchPayment);
        let output = "";
        output = `
        <div class="table-responsive text-nowrap px-3">
            <table class="table">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Sub total</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0">`;
        penjualan_product.map((v) => {
            output += `
                    <tr>
                        <td>${v.barang.nama_barang}</td>
                        <td>${formatUang(v.barang.hargajual_barang)}</td>
                        <td>${formatUang(v.jumlah_penjualanproduct)}</td>
                        <td>${formatUang(v.subtotal_penjualanproduct)}</td>
                    </tr>
                    `;
        });

        output += `</tbody>
                <tfoot>
                    <tr>
                        <td colspan="2"></td>
                        <td><strong>Total:</strong></td>
                        <td colspan="1" class="text-end">
                            <strong>${formatUang(
                                findData.total_penjualan
                            )}</strong>
                        </td>
                    </tr>`;
        penjualan_pembayaran.map((v) => {
            output += `
                        <tr>
                            <td colspan="2"></td>
                            <td><strong>${
                                v.kategori_pembayaran.nama_kpembayaran
                            }</strong></td>
                            <td colspan="1" class="text-end">
                                ${formatUang(v.bayar_ppembayaran)}
                            </td>
                        </tr>
                        `;
        });

        if (searchPayment.status_transaksi) {
            output += `
                    <tr>
                        <td colspan="2"></td>
                        <td><strong>Kembalian:</strong></td>
                        <td colspan="1" class="text-end">
                            ${formatUang(searchPayment.kembalian)}
                        </td>
                    </tr>`;
        }

        if (!searchPayment.status_transaksi) {
            output += `
                    <tr>
                        <td colspan="2"></td>
                        <td><strong>Hutang:</strong></td>
                        <td colspan="1" class="text-end">
                            ${formatUang(searchPayment.hutang)}
                        </td>
                    </tr>`;
        }

        output += `
                </tfoot>
            </table>
        </div>
            `;

        return output;
    }

    body.off("click", ".detail-pembelian");
    body.on("click", ".detail-pembelian", function (e) {
        e.preventDefault();
        const show = $(this).data("show");
        if (show === 1) {
            $(this).data("show", 0);
            $(this).html('<i class="fa-solid fa-eye-slash"></i>');
        } else {
            $(this).data("show", 1);
            $(this).html('<i class="fa-solid fa-eye"></i>');
        }
    });

    body.off("click", "td a.detail-pembelian");
    $("#dataTablePembelian tbody").on(
        "click",
        "td a.detail-pembelian",
        function () {
            var tr = $(this).closest("tr");
            var row = tablePembelian.row(tr);
            var id = $(this).data("id");

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass("shown");
            } else {
                // Open this row
                row.child(formatPembelian(id)).show();
                tr.addClass("shown");
            }
        }
    );
});
