<div class="card mt-4">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="w-50">
                Biaya Jasa Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    {{ $row->nonota_pservis }}</strong>
            </div>
            <div class="w-50">
                <x-form-select-vertical label="Cari Nama Servis" name="harga_servis_id" :data="$array_harga_servis" value="" />
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive text-nowrap px-3">
            <table class="table" id="dataTable">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Kategori Servis</th>
                        <th>Nama Servis</th>
                        <th>Mekanik</th>
                        <th>Biaya</th>
                        <th style="width: 15%;">Action</th>
                    </tr>
                </thead>
                <tbody class="table-border-bottom-0 onLoadServis" id="">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" class="text-end">
                            <strong>Total Biaya Jasa</strong>
                        </td>
                        <td>
                            <span class="totalHargaServis"></span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
