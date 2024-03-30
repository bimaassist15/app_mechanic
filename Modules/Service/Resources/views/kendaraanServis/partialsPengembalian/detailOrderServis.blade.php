<div class="card mt-4">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="w-50">
                Biaya Jasa Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap px-3">
            <table class="table" id="dataTableOrderServis">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kategori Servis</th>
                        <th>Nama Servis</th>
                        <th>Mekanik</th>
                        <th>Biaya</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 onLoadServis">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($row->orderServis as $item)
                        <tr>
                            <td>{{ $no++ }}</td>
                            <td>{{ $item->hargaServis->kategoriServis->nama_kservis }}</td>
                            <td>{{ $item->hargaServis->nama_hargaservis }}</td>
                            <td>{{ $item->usersMekanik->name ?? '-' }}</td>
                            <td>{{ UtilsHelp::formatUang($item->harga_orderservis) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    @php
                        $totalBiayaJasa = $row->orderServis->pluck('harga_orderservis')->sum();
                    @endphp
                    <tr>
                        <td colspan="4" class="text-end">
                            <strong>Total Biaya Jasa</strong>
                        </td>
                        <td>
                            <strong class="totalHargaServis">
                                {{ UtilsHelp::formatUang($totalBiayaJasa) }}
                            </strong>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
