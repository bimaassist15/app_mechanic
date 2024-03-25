<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon"
        href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/img/favicon/favicon.ico" />
    <title>Print Servis Kendaraan</title>

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        #tableKendaraanServis {
            border-collapse: collapse;
            width: 100%;
        }

        #tableKendaraanServis th,
        #tableKendaraanServis td {
            border: 1px solid black;
            padding: 10px
        }

        #tableJasaServis {
            border-collapse: collapse;
            width: 100%;
        }

        #tableJasaServis th,
        #tableJasaServis td {
            border: 1px solid black;
            padding: 10px
        }

        #tableSparepart {
            border-collapse: collapse;
            width: 100%;
        }

        #tableSparepart th,
        #tableSparepart td {
            border: 1px solid black;
            padding: 10px
        }

        .w-100 {
            width: 100%;
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
                        <tr>
                            <td>
                                <strong>{{ $myCabang->nowa_cabang }} / {{ $myCabang->notelpon_cabang }}</strong>
                            </td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table>
                        <tr>
                            <td>
                                <strong>No. Nota</strong>
                            </td>
                            <td>
                                <strong>:</strong>
                            </td>
                            <td>
                                <strong>{{ $row->nonota_pservis }}</strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Tanggal Diterima</td>
                            <td>:</td>
                            <td>{{ UtilsHelp::tanggalBulanTahunKonversi($row->updated_at) }}</td>
                        </tr>
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table>
                        <tr>
                            <td>
                                <strong>Pemilik</strong>
                            </td>
                            <td>
                                <strong>:</strong>
                            </td>
                            <td>
                                <strong>
                                    {{ $row->customer->nama_customer }}
                                </strong>
                            </td>
                        </tr>
                        <tr>
                            <td>Telpon</td>
                            <td>:</td>
                            <td>{{ $row->customer->nowa_customer }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div style="height: 10px;"></div>
        <table id="tableKendaraanServis">
            <tr>
                <th colspan="4" class="text-left">Kendaraan Servis</th>
            </tr>
            <tr>
                <td>
                    <strong>No. Polisi</strong>
                </td>
                <td>
                    <strong>Kendaraan</strong>
                </td>
                <td>
                    <strong>Kondisi Masuk</strong>
                </td>
                <td>
                    <strong>Kerusakan</strong>
                </td>
            </tr>
            <tr>
                <td>{{ $row->kendaraan->nopol_kendaraan }}</td>
                <td>{{ $row->kendaraan->jenis_kendaraan }}</td>
                <td>{{ $row->kondisi_pservis }}</td>
                <td>{{ $row->kerusakan_pservis }}</td>
            </tr>
        </table>
        <div style="height: 10px;"></div>
        <table id="tableJasaServis">
            <tr>
                <th colspan="4" class="text-left">Jasa Servis</th>
            </tr>
            <tr>
                <td>
                    <strong>No.</strong>
                </td>
                <td>
                    <strong>Nama Servis</strong>
                </td>
                <td>
                    <strong>Mekanik</strong>
                </td>
                <td>
                    <strong>Biaya</strong>
                </td>
            </tr>
            @php
                $no = 1;
            @endphp
            @foreach ($row->orderServis as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->hargaServis->nama_hargaservis }}</td>
                    <td>{{ $item->usersMekanik->name }}</td>
                    <td>{{ UtilsHelp::formatUang($item->harga_orderservis) }}</td>
                </tr>
            @endforeach

        </table>
        <div style="height: 10px;"></div>
        <table id="tableSparepart">
            <tr>
                <th colspan="7" class="text-left">Sparepart</th>
            </tr>
            <tr>
                <td>
                    <strong>No.</strong>
                </td>
                <td>
                    <strong>Nama Sparepart</strong>
                </td>
                <td>
                    <strong>Harga</strong>
                </td>
                <td>
                    <strong>Qty</strong>
                </td>
                <td>
                    <strong>Diskon</strong>
                </td>
                <td>
                    <strong></strong>
                </td>
                <td>
                    <strong>Sub Total</strong>
                </td>

            </tr>
            @php
                $no = 1;
            @endphp
            @foreach ($row->orderBarang as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->barang->nama_barang }}</td>
                    <td>{{ UtilsHelp::formatUang($item->barang->hargajual_barang) }}</td>
                    <td>{{ UtilsHelp::formatUang($item->qty_orderbarang) }}</td>
                    <td class="text-left">{{ $item->typediskon_orderbarang }}</td>
                    <td class="text-left">{{ UtilsHelp::formatUang($item->diskon_orderbarang) }}</td>
                    <td>{{ UtilsHelp::formatUang($item->subtotal_orderbarang) }}</td>
                </tr>
            @endforeach

        </table>
        <div style="height: 10px;"></div>
        <table class="w-100">
            <tr>
                <td style="width: 80%; text-align: right;">Total Biaya</td>
                <td>:</td>
                <td style="width: 20%; text-align: right;">{{ UtilsHelp::formatUang($row->totalbiaya_pservis) }}</td>
            </tr>
            @foreach ($row->pembayaranServis as $item)
                <tr>
                    <td style="width: 80%; text-align: right;">{{ $item->kategoriPembayaran->nama_kpembayaran }}</td>
                    <td>:</td>
                    <td style="width: 20%; text-align: right;">
                        {{ $item->deposit_pservis != null ? UtilsHelp::formatUang($item->deposit_pservis) : UtilsHelp::formatUang($item->bayar_pservis) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td style="width: 80%; text-align: right;">Kembalian</td>
                <td>:</td>
                <td style="width: 20%; text-align: right;">{{ UtilsHelp::formatUang($row->kembalian_pservis) }}</td>
            </tr>
            @if ($row->hutang_pservis)
                <tr>
                    <td style="width: 80%; text-align: right;">Hutang</td>
                    <td>:</td>
                    <td style="width: 20%; text-align: right;">{{ UtilsHelp::formatUang($row->hutang_pservis) }}</td>
                </tr>
            @endif
        </table>
        <div style="height: 25px;"></div>
        <div class="text-center">
            <strong style="font-size: 12px;">Powered By: {{ UtilsHelp::createdApp() }}</strong>
        </div>
    </div>
</body>

</html>
