<div class="row">
    <div class="col-lg-12">
        <div class="table-responsive">
            <table class="table">
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
        </div>
    </div>
</div>
