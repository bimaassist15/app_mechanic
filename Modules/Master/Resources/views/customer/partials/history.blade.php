<div class="mb-3">
    <div class="row mb-3">
        <div class="col-lg-12 bg-primary" style="border-radius: 5px;">
            <h5 class="m-0 text-white p-2">
                History Pembelian Customer
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
                            <th>No. Invoice</th>
                            <th>Tanggal Transaksi</th>
                            <th>Kasir</th>
                            <th>Total</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($row->penjualan as $item)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $item->invoice_penjualan }}</td>
                                <td>{{ UtilsHelp::tanggalBulanTahunKonversi($item->transaksi_penjualan) }}</td>
                                <td>{{ $item->users->name }}</td>
                                <td>{{ UtilsHelp::formatUang($item->total_penjualan) }}</td>
                                <td>
                                    <a href="#" data-id="{{ $item->id }}"
                                        class="btn btn-primary detail-pembelian btn-small" data-show="1"
                                        title="Detail Pembelian">
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
