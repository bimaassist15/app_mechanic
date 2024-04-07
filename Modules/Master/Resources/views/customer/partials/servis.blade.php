<div class="mb-3">
    <div class="row mb-3">
        <div class="col-lg-12 bg-primary" style="border-radius: 5px;">
            <h5 class="m-0 text-white p-2">
                History Servis Customer
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTablePembelian" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th>Nota</th>
                            <th>Tanggal Masuk</th>
                            <th>Status</th>
                            <th>Tanggal Ambil</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                            $setUrl = 'kendaraanServis';
                        @endphp

                        @foreach ($row->penerimaanServis as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nonota_pservis }}</td>
                                <td>{{ UtilsHelp::tanggalBulanTahunKonversi($item->created_at) }}</td>
                                <td>{{ ucwords($item->status_pservis) }}</td>
                                <td>-</td>
                                <td>
                                    <a target="_blank" href="{{ url('service/' . $setUrl . '/' . $item->id) }}"
                                        data-id="{{ $item->id }}" class="btn btn-primary detail-servis btn-small"
                                        title="Detail Servis">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
