<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon"
        href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/img/favicon/favicon.ico" />
    <title>Nota Cetak Pos</title>

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        #table_invoice {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
        }

        #table_invoice th,
        #table_invoice td {
            border-collapse: collapse;
            border: 1px solid black;
            padding: 10px
        }
    </style>
</head>

<body>
    <div style="width: 100%; margin: 0 auto;">
        <table style="width: 100%">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                <strong>{{ $myCabang->bengkel_cabang }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>{{ $myCabang->alamat_cabang }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>{{ $myCabang->kota_cabang }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td><strong>No. Invoice</strong></td>
                            <td style="padding: 0 15px"><strong>:</strong></td>
                            <td><strong>{{ $penjualan->invoice_penjualan }}</strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td style="padding: 0 15px">:</td>
                            <td>{{ UtilsHelp::tanggalBulanTahunKonversi($penjualan->transaksi_penjualan) }}</td>
                        </tr>
                        <tr>
                            <td>Kepada</td>
                            <td style="padding: 0 15px">:</td>
                            <td>{{ $penjualan->customer->nama_customer ?? 'Umum' }}</td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table>
                        <tr>
                            <td>Transaksi</td>
                            <td style="padding: 0 15px">:</td>
                            <td>{{ ucwords($penjualan->tipe_penjualan) }}</td>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <td style="padding: 0 15px">:</td>
                            <td>{{ ucwords($penjualan->users->name) }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <table id="table_invoice">
            <thead>
                <tr>
                    <th>Deskripsi Barang</th>
                    <th>Qty</th>
                    <th>Harga</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penjualan->penjualanProduct as $item)
                    <tr>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td>{{ $item->jumlah_penjualanproduct }}</td>
                        <td>{{ UtilsHelp::formatUang($item->barang->hargajual_barang) }}</td>
                        <td>{{ UtilsHelp::formatUang($item->subtotal_penjualanproduct) }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>

        <table style="margin-top: 30px; width: 100%;">
            <tr>
                <td style="text-align: center; width: 30%;">
                    <strong>
                        {{ $myCabang->bengkel_cabang }} <br>
                        {{ $myCabang->alamat_cabang }}
                    </strong>

                    <div style="margin-top: 70px;"></div>

                    <div style="width: 100%; border-top: 1px solid black;"></div>
                </td>
                <td style="vertical-align: top; text-align: right;">
                    <table style="margin-left: auto;">
                        <tr>
                            <td>Total</td>
                            <td>:</td>
                            <td style="padding: 0 80px;">Rp.</td>
                            <td>{{ UtilsHelp::formatUang($penjualan->total_penjualan) }}</td>
                        </tr>
                        @if ($penjualan->hutang_penjualan)
                            <tr>
                                <td>Hutang</td>
                                <td>:</td>
                                <td style="padding: 0 80px;">Rp.</td>
                                <td>{{ UtilsHelp::formatUang($penjualan->hutang_penjualan) }}</td>
                            </tr>
                        @endif
                        @foreach ($penjualan->penjualanPembayaran as $item)
                            <tr>
                                <td>{{ $item->kategoriPembayaran->nama_kpembayaran }}</td>
                                <td>:</td>
                                <td style="padding: 0 80px;">Rp.</td>
                                <td>{{ UtilsHelp::formatUang($item->bayar_ppembayaran) }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td>Kembalian</td>
                            <td>:</td>
                            <td style="padding: 0 80px;">Rp.</td>
                            <td>{{ UtilsHelp::formatUang($penjualan->kembalian_penjualan) }} </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <div style="margin-top: 20px;">
                    </div>
                    <div style="border: 1px dashed black;"></div>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;">
                    <div style="margin-top: 10px;">
                    </div>
                    <strong>Powered By: {{ UtilsHelp::createdApp() }}</strong>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
