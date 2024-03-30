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