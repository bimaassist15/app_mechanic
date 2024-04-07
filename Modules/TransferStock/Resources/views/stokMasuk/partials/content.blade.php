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
                        <td colspan="2">
                            <form action="#" id="form-submit">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <x-form-select-vertical label="Status" name="status_tstock" :data="$array_status_tstock"
                                            value="{{ $row->status_tstock }}" />
                                    </div>
                                    <div class="col-lg-4">
                                        <div style="margin-top: 29px;">
                                            <x-button-submit-modal />
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </td>
                        <td>
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
