<div class="mb-3">
    <div class="row mb-3">
        <div class="col-lg-12 bg-primary" style="border-radius: 5px;">
            <h5 class="m-0 text-white p-2">
                Kendaraan Customer
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTableKendaraan" style="width: 100%;">
                    <thead>
                        <tr>
                            <th style="width: 5%;">No.</th>
                            <th>No. Pol</th>
                            <th>Merek</th>
                            <th>Tipe</th>
                            <th>Jenis</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($row->kendaraan as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->nopol_kendaraan }}</td>
                                <td>{{ $item->merek_kendaraan }}</td>
                                <td>{{ $item->tipe_kendaraan }}</td>
                                <td>{{ $item->jenis_kendaraan }}</td>
                                <td>
                                    <a href="#" data-id="{{ $item->id }}"
                                        class="btn btn-primary detail-kendaraan btn-small" data-show="1"
                                        title="Detail Kendaraan">
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
