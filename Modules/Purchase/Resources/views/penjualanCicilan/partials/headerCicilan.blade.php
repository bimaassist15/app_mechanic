<div class="card-body">
    <table class="w-100">
        <tr>
            <td>
                <table class="w-100">
                    <tr>
                        <td>No. Invoice</td>
                        <td>:</td>
                        <td><strong class="text-primary">{{ $penjualan->invoice_penjualan }}</strong></td>
                    </tr>
                    <tr>
                        <td>Tanggal transaksi</td>
                        <td>:</td>
                        <td>{{ UtilsHelp::tanggalBulanTahunKonversi($penjualan->transaksi_penjualan) }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="w-100">
                    <tr>
                        <td>Total Transaksi</td>
                        <td>:</td>
                        <td>
                            <span>
                                {{ UtilsHelp::formatUang($penjualan->total_penjualan) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Bayar</td>
                        <td>:</td>
                        <td>
                            <span class="header_bayar_penjualan">
                                {{ UtilsHelp::formatUang($penjualan->bayar_penjualan) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Hutang</td>
                        <td>:</td>
                        <td>
                            <span class="header_hutang_penjualan">
                                {{ UtilsHelp::formatUang($penjualan->hutang_penjualan) }}
                            </span>

                        </td>
                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td>:</td>
                        <td>
                            <span class="header_kembalian_penjualan">
                                {{ UtilsHelp::formatUang($penjualan->kembalian_penjualan) }}
                            </span>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>
