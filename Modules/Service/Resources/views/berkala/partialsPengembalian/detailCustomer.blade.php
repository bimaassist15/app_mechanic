<div class="card mt-4">
    <div class="card-header">
        Data Customer & Kendaraan Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
            {{ $row->nonota_pservis }}</strong>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-lg-6">
                <x-data-customer label="Nama Customer" value="{{ $row->kendaraan->customer->nama_customer }}" />
                <x-data-customer label="Kategori Servis"
                    value="{{ $row->kategoriServis->nama_kservis }} / {{ $row->kendaraan->nopol_kendaraan }} / {{ $row->kendaraan->jenis_kendaraan }}" />

            </div>
            <div class="col-lg-6">
                <x-data-customer label="Penerima / Tanggal terima"
                    value="{{ $row->users->name }} / {{ UtilsHelp::tanggalBulanTahunKonversi($row->created_at) }}" />
                <x-data-customer label="Kerusakan" value="{{ $row->kerusakan_pservis }}" />
            </div>
        </div>
        <hr>
        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="d-flex justify-content-center flex-wrap">
                    <x-button-main title="Detail Kendaraan" className="detail-penerimaan-servis me-2"
                        typeModal="extraLargeModal"
                        urlCreate="{{ url('service/penerimaanServis/detail/' . $row->id . '/penerimaanServis') }}"
                        icon='<i class="fa-solid fa-gear"></i>' color="btn-secondary" />

                    <x-button-main title="Identitas Customer" className="detail-customer me-2"
                        typeModal="extraLargeModal" urlCreate="{{ url('master/customer/' . $row->customer->id) }}"
                        icon='<i class="fa-solid fa-user"></i>' color="btn-warning" />

                    <x-button-main title="Identitas Kendaraan" className="identitas-kendaraan"
                        typeModal="extraLargeModal" urlCreate="{{ url('master/kendaraan/' . $row->kendaraan->id) }}"
                        icon='<i class="fa-solid fa-bicycle"></i>' color="btn-dark" />
                </div>
            </div>
        </div>
    </div>
</div>
