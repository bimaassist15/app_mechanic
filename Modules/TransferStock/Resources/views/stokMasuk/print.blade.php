<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon"
        href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/img/favicon/favicon.ico" />
    <link rel="stylesheet" href="{{ asset('library/fontawesome-free-6.5.1-web/css/all.css') }}">
    <title>Transfer Stok Keluar</title>

    <style>
        * {
            font-family: Arial, Helvetica, sans-serif;
        }

        #table_transfer {
            border-collapse: collapse;
            margin-top: 20px;
            width: 100%;
        }

        #table_transfer th,
        #table_transfer td {
            border-collapse: collapse;
            border: 1px solid black;
            padding: 10px
        }
    </style>
</head>

<body>
    <section style="width: 100%; margin: 0 auto;">
        <table style="width: 100%;">
            <td>
                <table style="width: 100%;">
                    <tr>
                        <td colspan="2">
                            <h4>
                                <i class="fa-solid fa-globe"></i> No. Invoice:
                                {{ $row->kode_tstock }}
                            </h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Dari Pengirim
                        </td>
                        <td>
                            Data Penerima
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{ $row->cabangPemberi->nama_cabang }}</strong>
                        </td>
                        <td>
                            <strong>{{ $row->cabangPenerima->nama_cabang }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ $row->cabangPemberi->alamat_cabang }}
                        </td>
                        <td>
                            {{ $row->cabangPenerima->alamat_cabang }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Telp/Wa:
                            {{ $row->cabangPemberi->nowa_cabang }}/{{ $row->cabangPemberi->notelpon_cabang }}
                        </td>
                        <td>
                            Telp/Wa:
                            {{ $row->cabangPenerima->nowa_cabang }}/{{ $row->cabangPenerima->notelpon_cabang }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email: {{ $row->cabangPemberi->email_cabang }}
                        </td>
                        <td>
                            Email: {{ $row->cabangPenerima->nowa_cabang }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Kasir: {{ $row->users->name }}
                        </td>
                        <td>
                            Kasir: {{ $row->users->name }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong> {{ $row->cabangPemberi->kota_cabang }} </strong>
                        </td>
                        <td>
                            <strong> {{ $row->cabangPenerima->kota_cabang }} </strong>
                        </td>
                    </tr>
                </table>
            </td>
            <td>
                <table style="width: 100%;">
                    <tr>
                        <td>Tanggal Kirim: </td>
                        <td>{{ UtilsHelp::tanggalBulanTahunKonversi($row->tanggalkirim_tstock) }}</td>
                    </tr>
                    <tr>
                        <td>Tanggal Diterima: </td>
                        <td>{{ $row->tanggalditerima_tstock != null ? UtilsHelp::tanggalBulanTahunKonversi($row->tanggalditerima_tstock) : '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>Status: </td>
                        <td>{{ $row->status_tstock }}</td>
                    </tr>
                </table>
            </td>
        </table>

        <table id="table_transfer">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Barang</th>
                    <th>Qty</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no = 1;
                @endphp
                @foreach ($row->transferDetail as $key => $item)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $item->barang->nama_barang }}</td>
                        <td>{{ UtilsHelp::formatUang($item->qty_tdetail) }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3">
                        <strong>
                            {{ $row->keterangan_tstock }}
                        </strong>
                    </td>
                </tr>
            </tfoot>
        </table>
    </section>
</body>

</html>
