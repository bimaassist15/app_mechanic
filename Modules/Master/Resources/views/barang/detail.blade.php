<div>
    <div class="modal-body">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-menu me-1"></i> Aksi
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center btn-edit"
                            data-typemodal="extraLargeModal"
                            data-urlcreate="{{ url('master/barang/' . $row->id . '/edit') }}">
                            <i class="bx bx-chevron-right scaleX-n1-rtl"></i>Edit</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center btn-delete"
                            data-url="{{ url('master/barang/' . $row->id . '?_method=delete') }}">
                            <i class="bx bx-chevron-right scaleX-n1-rtl"></i>Hapus</a>
                    </li>
                    <li>
                        <a target="_blank" href="{{ url('master/serialBarang?barang_id=' . $row->id) }}"
                            class="dropdown-item d-flex align-items-center"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Data Serial Number</a>
                    </li>
                    <li>
                        <a target="_blank" href="{{ url('master/generateBarcode?barang_id=' . $row->id) }}"
                            class="dropdown-item d-flex align-items-center">
                            <i class="bx bx-chevron-right scaleX-n1-rtl"></i>Generate Barcode
                        </a>
                    </li>

                </ul>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <x-data-horizontal label="Kode Barang" value="{{ $row->barcode_barang }}" />
                        <x-data-horizontal label="Nama Barang" value="{{ $row->nama_barang }}" />
                        <x-data-horizontal label="Deskripsi" value="{{ $row->deskripsi_barang }}" />
                        <x-data-horizontal label="Harga Jual"
                            value="{{ number_format($row->hargajual_barang, 0, '.', ',') }}" />
                        <x-data-horizontal label="Kategori" value="{{ $row->kategori->nama_kategori }}" />
                    </div>
                    <div class="col-lg-6">
                        <x-data-horizontal label="Satuan" value="{{ $row->satuan->nama_satuan }}" />
                        <x-data-horizontal label="Non-SN Or SN" value="{{ strtoupper($row->snornonsn_barang) }}" />
                        <x-data-horizontal label="Lokasi Rak" value="{{ $row->lokasi_barang }}" />
                        <x-data-horizontal label="Status Barang" value="{{ $row->status_barang }}" />
                        <x-data-horizontal label="Stok Barang" value="{{ $row->stok_barang }}" />
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <x-button-ok-modal />
    </div>
</div>
