<div class="card-body">
    <table class="w-100">
        <tr>
            <td>
                <table class="w-100">
                    <tr>
                        <td>No. Invoice</td>
                        <td>:</td>
                        <td><strong class="text-primary">{{ $pembelian->invoice_pembelian }}</strong></td>
                    </tr>
                    <tr>
                        <td>Tanggal transaksi</td>
                        <td>:</td>
                        <td>{{ UtilsHelp::tanggalBulanTahunKonversi($pembelian->transaksi_pembelian) }}</td>
                    </tr>
                </table>
            </td>
            <td>
                <table class="w-100">
                    <tr>
                        <td>Hutang</td>
                        <td>:</td>
                        <td>
                            <span class="header_hutang_pembelian">
                                {{ UtilsHelp::formatUang($getPembelian['hutang']) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Bayar</td>
                        <td>:</td>
                        <td>
                            <span class="header_bayar_pembelian">
                                {{ UtilsHelp::formatUang($getPembelian['bayar']) }}
                            </span>

                        </td>
                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td>:</td>
                        <td>
                            <span class="header_kembalian_pembelian">
                                {{ UtilsHelp::formatUang($getPembelian['kembalian']) }}
                            </span>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>
