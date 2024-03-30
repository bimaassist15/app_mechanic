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
            <td>{{ $item->usersMekanik->name ?? '-' }}</td>
            <td>{{ UtilsHelp::formatUang($item->harga_orderservis) }}</td>
        </tr>
    @endforeach

</table>
