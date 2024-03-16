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
                        <td>Total Transaksi</td>
                        <td>:</td>
                        <td>
                            <span>
                                {{ UtilsHelp::formatUang($pembelian->total_pembelian) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Bayar</td>
                        <td>:</td>
                        <td>
                            <span class="header_bayar_pembelian">
                                {{ UtilsHelp::formatUang($pembelian->bayar_pembelian) }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <td>Hutang</td>
                        <td>:</td>
                        <td>
                            <span class="header_hutang_pembelian">
                                {{ UtilsHelp::formatUang($pembelian->hutang_pembelian) }}
                            </span>

                        </td>
                    </tr>
                    <tr>
                        <td>Kembalian</td>
                        <td>:</td>
                        <td>
                            <span class="header_kembalian_pembelian">
                                {{ UtilsHelp::formatUang($pembelian->kembalian_pembelian) }}
                            </span>

                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</div>
