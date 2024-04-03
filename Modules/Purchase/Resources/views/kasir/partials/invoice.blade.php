<div class="card-header bg-primary text-white p-3">
    <strong>Invoice Summary</strong>
</div>
<div class="card-body">
    <div class="row mt-4">
        <div class="col-lg-6">
            <div class="form-group">
                <h3 for="" class="fw-bold p-0 m-0">No. Invoice</h3>
                <strong>{{ $noInvoice }}</strong>
            </div>
        </div>
        <div class="col-lg-6">
            <x-form-select-vertical label="Cari Barang" name="barang_id" :data="$array_barang" value="" />
        </div>
    </div>
    <hr style="color: #1381f0;" />

    <div class="table-responsive text-nowrap px-3">
        <table class="table" id="dataTable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th style="width: 15%;">Qty</th>
                    <th>Harga</th>
                    <th>Diskon</th>
                    <th style="width: 15%;"></th>
                    <th>Total Harga</th>
                    <th>#</th>
                </tr>
            </thead>
            <tbody class="table-border-bottom-0 orderBarang">
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="7">
                        <div class="d-flex justify-content-center flex-wrap align-items-center">
                            <h4 class="fw-bold p-0 m-0">Total: Rp. <span class="total_harga_all" class="me-3">0</span>
                            </h4>
                            {{-- <strong class="text-primary" style="cursor: pointer;"> PRINT</strong> --}}
                        </div>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
