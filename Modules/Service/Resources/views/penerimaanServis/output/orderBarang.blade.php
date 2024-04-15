@php
    $no = 1;
    $totalOrderBarang = $row->orderBarang->sum('subtotal_orderbarang');
    $allowedSudahDiambil = ['sudah diambil', 'komplain garansi'];
@endphp

@foreach ($row->orderBarang as $item)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $item->barang->nama_barang }}</td>
        <td>{{ UtilsHelp::formatUang($item->barang->hargajual_barang) }}</td>
        <td>
            <input name="qty_orderbarang" class="qty_orderbarang form-control" data-id="{{ $item->id }}"
                value="{{ UtilsHelp::formatUang($item->qty_orderbarang) }}"
                title="Stok Barang: {{ $item->barang->stok_barang }}"
                {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }} />
        </td>
        <td>
            <select name="typediskon_orderbarang" class="form-select" data-id="{{ $item->id }}"
                {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}>
                <option value="" selected>Tipe Diskon</option>
                @foreach ($tipeDiskon as $value => $itemDiskon)
                    <option value="{{ $value }}">{{ $itemDiskon }}</option>
                @endforeach
            </select>
        </td>
        <td>
            <input name="diskon_orderbarang" class="diskon_orderbarang form-control" data-id="{{ $item->id }}"
                value="{{ $item->diskon_orderbarang == null ? '' : UtilsHelp::formatUang($item->diskon_orderbarang) }}"
                {{ $item->typediskon_orderbarang == null ? 'disabled' : '' }} />
        </td>
        <td>
            <span class="output_subtotal_orderbarang" data-id="{{ $item->id }}">
                {{ UtilsHelp::formatUang($item->subtotal_orderbarang) }}
            </span>
        </td>
        <td>
            <button data-urlcreate="{{ url('/service/orderBarang/' . $item->id . '?_method=delete') }}"
                data-id="{{ $item->id }}" class="btn btn-danger delete-order-barang btn-small"
                title="Delete Order Barang"
                {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}>
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    </tr>
@endforeach
<tr id="load_viewdata_order_barang" class="text-center d-none">
    <td colspan="8">
        <div>
            <div>
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <strong>Loading...</strong>
        </div>
    </td>
</tr>
<tr>
    <td colspan="6" class="text-end">
        <strong>Total Biaya Sparepart</strong>
    </td>
    <td>
        <span class="totalOrderBarang">{{ UtilsHelp::formatUang($totalOrderBarang) }}</span>
    </td>
    <td></td>
</tr>
