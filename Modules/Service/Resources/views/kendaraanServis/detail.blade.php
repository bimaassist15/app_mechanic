<div>
    <div class="modal-body">
        <div class="d-flex justify-content-between">
            <div>
                <h4 style="margin: 0; padding: 0;">Data Servis <strong
                        style="font-weight: 800; color:rgb(102, 102, 230)">No. Nota
                        7</strong> - <strong style="font-weight: 800; color:rgb(223, 158, 62);">No. Antrian 2</strong>
                </h4>
                <small>22 Februari 2024 - Tipe servis: Datang Langsung</small>
            </div>
            <div>
                <div class="row justify-content-end">
                    <div class="col-sm-12">
                        <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="bx bx-menu me-1"></i> Aksi
                        </button>
                        <ul class="dropdown-menu">
                            <li>
                                <a target="_blank" href="{{ url('service/kendaraanServis/edit/service') }}"
                                    class="dropdown-item d-flex align-items-center"><i
                                        class="bx bx-chevron-right scaleX-n1-rtl"></i>Edit</a>
                            </li>
                            <li>
                                <a target="_blank" href="{{ url('service/kendaraanServis/print/service') }}"
                                    class="dropdown-item d-flex align-items-center"><i
                                        class="bx bx-chevron-right scaleX-n1-rtl"></i>Print</a>
                            </li>
                            <li>
                                <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"><i
                                        class="bx bx-chevron-right scaleX-n1-rtl"></i>Hapus</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Data Customer & Kendaraan Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    7</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <x-data-customer label="Nama Customer" value="By Bim" />
                        <x-data-customer label="Kategori Servis"
                            value="Service Testing / 4989289323 / Yamaha Matic CB150R" />

                    </div>
                    <div class="col-lg-6">
                        <x-data-customer label="Penerima / Tanggal terima" value="Bg Bim / 6282277506232" />
                        <x-data-customer label="Kerusakan" value="Kendaraan rusak testing" />
                    </div>
                </div>
                <hr>
                <div class="row mt-2">
                    <div class="col-lg-12">
                        <div class="d-flex justify-content-center flex-wrap">
                            <x-button-main title="Detail Kendaraan" className="detail-kendaraan me-2"
                                typeModal="extraLargeModal" urlCreate="" icon='<i class="fa-solid fa-gear"></i>'
                                color="btn-secondary" />
                            <x-button-main title="Identitas Customer" className="detail-customer me-2"
                                typeModal="extraLargeModal" urlCreate="" icon='<i class="fa-solid fa-user"></i>'
                                color="btn-warning" />
                            <x-button-main title="Identitas Kendaraan" className="identitas-kendaraan"
                                typeModal="extraLargeModal" urlCreate="" icon='<i class="fa-solid fa-bicycle"></i>'
                                color="btn-dark" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Biaya Jasa Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    7</strong>
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
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>1</td>
                                <td>Motor</td>
                                <td>Servis Mesin</td>
                                <td>Afan T</td>
                                <td>Rp. 70.000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-end">
                                    <strong>Total Biaya Jasa</strong>
                                </td>
                                <td>Rp. 70.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Biaya Sparepart <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    7</strong>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>No. SN</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>1</td>
                                <td>Motor</td>
                                <td>Servis Mesin</td>
                                <td>Afan T</td>
                                <td>3829238</td>
                                <td>Rp. 70.000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="text-end">
                                    <strong>Total Biaya Sparepart</strong>
                                </td>
                                <td>Rp. 70.000</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                History Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    7</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <x-data-customer label="Tanggal Masuk" value="22 Februari 2024 10:00 Wib" />
                        <x-data-customer label="Status Servis (22 Februari 2024)" value="Sudah diambil" />
                        <x-data-customer label="Penerima / Pembuat Nota Penerimaan Servis" value="Ijat" />
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-8">
                        <strong>Detail History Servis</strong>
                        <table class="w-100 table">
                            <tr>
                                <td>1</td>
                                <td>22 Februari 2024 10:00 Wib</td>
                                <td>Bisa Diambil</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>22 Februari 2024 10:00 Wib</td>
                                <td>No. Antrian Masuk</td>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>22 Februari 2024 10:00 Wib</td>
                                <td>Cancel</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Komplain Garansi Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    7</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <x-data-customer label="Keluhan" value="Menyala Abangku" />
                        <x-data-customer label="Penerima Komplain" value="Bg Bim" />
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-4">
            <div class="card-header">
                Informasi Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                    7</strong>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-8">
                        <x-data-customer label="Sub Total" value="Rp. 70.000" />
                        <x-data-customer label="Total Sisa Bayar" value="Rp. -30.000" />
                        <x-data-customer label="Catatan Teknisi" value="Tolong data lagi setiap 3 bulan sekali" />
                        <x-data-customer label="DP (Bayar Diawal)" value="Rp. 100.000" />
                        <x-data-customer label="Kondisi Barang Servis" value="Sudah bagus" />
                        <x-data-customer label="Status Servis" value="Sudah Diambil" />
                        <x-data-customer label="Servis Berkala" value="3 Bulan Sekali" />
                        <x-data-customer label="Servis Garansi" value="1 Bulan (24 Maret 2024)" />
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
