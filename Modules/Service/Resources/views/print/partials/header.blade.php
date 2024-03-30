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
        <td class="v-align-top">
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
                    <td>
                        {{ $row->tanggalambil_pservis != null ? UtilsHelp::tanggalBulanTahunKonversi($row->tanggalambil_pservis) : '-' }}
                    </td>
                </tr>
            </table>
        </td>
        <td class="v-align-top">
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
