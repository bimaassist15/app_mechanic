<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <div style="width: 70%; margin: 0 auto;">
        <table style="width: 100%">
            <tr>
                <td>
                    <table>
                        <tr>
                            <td>
                                <strong>Bengkel Motor Maju Lancar</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>RT 1/ RW 2 Jln Pahlawan Pertama</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <strong>Surabaya Jawa Timur</strong>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                    <table>
                        <tr>
                            <td><strong>No. Invoice</strong></td>
                            <td style="padding: 0 15px"><strong>:</strong></td>
                            <td><strong>20240224</strong></td>
                        </tr>
                        <tr>
                            <td>Tanggal</td>
                            <td style="padding: 0 15px">:</td>
                            <td>23 September 2022 11:30:44 am</td>
                        </tr>
                        <tr>
                            <td>Kepada</td>
                            <td style="padding: 0 15px">:</td>
                            <td>Rinto Warhab</td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table>
                        <tr>
                            <td>Transaksi</td>
                            <td style="padding: 0 15px">:</td>
                            <td>Cash</td>
                        </tr>
                        <tr>
                            <td>Kasir</td>
                            <td style="padding: 0 15px">:</td>
                            <td>Kasir</td>
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
                <tr>
                    <td>Busi Honda Supra 125 CC </td>
                    <td>1</td>
                    <td>25.000</td>
                    <td>25.000</td>
                </tr>
            </tbody>
        </table>

        <table style="margin-top: 30px; width: 100%;">
            <tr>
                <td style="text-align: center; width: 30%;">
                    <strong>
                        Bengkel Motor Maju Lancar <br>
                        Surabaya Jawa Timur
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
                            <td>25.000</td>
                        </tr>
                        <tr>
                            <td>Bayar</td>
                            <td>:</td>
                            <td style="padding: 0 80px;">Rp.</td>
                            <td>25.000</td>
                        </tr>
                        <tr>
                            <td>Kembali</td>
                            <td>:</td>
                            <td style="padding: 0 80px;">Rp.</td>
                            <td>0 </td>
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
                    <strong>Powered By: Bima Ega Farizky</strong>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
