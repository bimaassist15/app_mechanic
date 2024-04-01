<div class="card mt-4">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="w-50">
                Biaya Sparepart <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
        </div>

    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap px-3">
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Qty</th>
                        <th>Diskon</th>
                        <th></th>
                        <th>Sub Total</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 loadOrderBarangKendaraan">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($row->orderBarang as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->barang->nama_barang }}</td>
                            <td>{{ UtilsHelp::formatUang($item->barang->hargajual_barang) }}</td>
                            <td>{{ UtilsHelp::formatUang($item->qty_orderbarang) }}</td>
                            <td>{{ ucfirst($item->typediskon_orderbarang) }}</td>
                            <td>{{ UtilsHelp::formatUang($item->diskon_orderbarang) }}</td>
                            <td>{{ UtilsHelp::formatUang($item->subtotal_orderbarang) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @php
                        $totalBiayaSparepart = $row->orderBarang->pluck('subtotal_orderbarang')->sum();
                    @endphp
                    <tr>
                        <td colspan="6" class="text-end">
                            <strong>Total Biaya Sparepart</strong>
                        </td>
                        <td class="">
                            <strong class="totalHargaBarang">
                                {{ UtilsHelp::formatUang($totalBiayaSparepart) }}
                            </strong>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
