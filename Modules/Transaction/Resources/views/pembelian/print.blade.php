@php
    $getPembelian = UtilsHelp::paymentStatisPembelian($pembelian->id);
@endphp
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
                            <td><strong>{{ $pembelian->invoice_pembelian }}</strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td style="padding: 0 15px">:</td>
                            <td>{{ UtilsHelp::tanggalBulanTahunKonversi($pembelian->transaksi_pembelian) }}</td>
                        </tr>
                        <tr>
                            <td>Kepada</td>
                            <td style="padding: 0 15px">:</td>
                            <td>{{ $pembelian->supplier->nama_supplier ?? 'Umum' }}</td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table>
                        <tr>
                            <td>Transaksi</td>
                            <td style="padding: 0 15px">:</td>
                            <td>{{ $getPembelian['tipe_transaksi'] }}
                            </td>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <td style="padding: 0 15px">:</td>
                            <td>{{ ucwords($pembelian->users->name) }}</td>
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
                @foreach ($pembelian->pembelianProduct as $item)
                    <tr>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td>{{ $item->jumlah_pembelianproduct }}</td>
                        <td>{{ UtilsHelp::formatUang($item->barang->hargajual_barang) }}</td>
                        <td>{{ UtilsHelp::formatUang($item->subtotal_pembelianproduct) }}</td>
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
                            <td>{{ UtilsHelp::formatUang($pembelian->total_pembelian) }}</td>
                        </tr>
                        @foreach ($pembelian->pembelianPembayaran as $item)
                            <tr>
                                <td>{{ $item->kategoriPembayaran->nama_kpembayaran }}</td>
                                <td>:</td>
                                <td style="padding: 0 80px;">Rp.</td>
                                <td>{{ UtilsHelp::formatUang($item->bayar_pbpembayaran) }}</td>
                            </tr>
                        @endforeach
                        @if ($getPembelian['hutang'])
                            <tr>
                                <td>Hutang</td>
                                <td>:</td>
                                <td style="padding: 0 80px;">Rp.</td>
                                <td>{{ UtilsHelp::formatUang($getPembelian['hutang']) }}</td>
                            </tr>
                        @endif
                        @if (!$getPembelian['hutang'])
                            <tr>
                                <td>Kembalian</td>
                                <td>:</td>
                                <td style="padding: 0 80px;">Rp.</td>
                                <td>
                                    {{ UtilsHelp::formatUang($getPembelian['kembalian']) }}
                                </td>
                            </tr>
                        @endif
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
