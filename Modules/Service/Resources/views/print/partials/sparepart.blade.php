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