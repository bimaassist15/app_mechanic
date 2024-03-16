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
                        <td>Hutang</td>
                        <td>:</td>
                        <td>
                            <span class="header_hutang_penjualan">
                                {{ UtilsHelp::formatUang($getPenjualan['hutang']) }}
                            </span>

                        </td>
                    </tr>
                    <tr>
                        <td>Bayar</td>
                        <td>:</td>
                        <td>
                            <span class="header_bayar_penjualan">
                                {{ UtilsHelp::formatUang($getPenjualan['bayar']) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td>:</td>
                        <td>
                            <span class="header_kembalian_penjualan">
                                {{ UtilsHelp::formatUang($getPenjualan['kembalian']) }}
                            </span>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>
