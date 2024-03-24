<div class="d-flex justify-content-between">
    <div>
        <h4 style="margin: 0; padding: 0;">Data Servis <strong style="font-weight: 800; color:rgb(102, 102, 230)">No.
                Nota
                {{ $row->nonota_pservis }}</strong> - <strong style="font-weight: 800; color:rgb(223, 158, 62);">No.
                Antrian {{ $row->noantrian_pservis }}</strong>
        </h4>
        <small>22 Februari 2024 - Tipe servis: Datang Langsung</small>
    </div>
    <div>
        <div class="row justify-content-end">
            <div class="col-sm-12">
                {{ Breadcrumbs::render('detailPenerimaanServis', $row->id) }}

            </div>
        </div>
    </div>
</div>
