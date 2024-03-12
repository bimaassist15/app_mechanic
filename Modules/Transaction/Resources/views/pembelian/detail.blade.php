<div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <table class="w-100">
                    <tr>
                        <td colspan="2">
                            <h4><i class="fa-solid fa-globe"></i> No. Invoice: 2389289123</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Dari
                        </td>
                        <td>
                            Supplier
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>Bengkel Motor maju lancar</strong>
                        </td>
                        <td>
                            <strong>Supplier Testing</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            JL. Manunggal Pekanbaru
                        </td>
                        <td>
                            <a href="https://wa.me/6282277506232">Link Alamat</a>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Telp/Wa: 082277506232/082270595453
                        </td>
                        <td>
                            Telp/Wa: 082277506232
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email: Ijat15@gmail.com
                        </td>
                        <td>
                            Perusahaan:PT Supplier Testing
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Kasir: ProgBim
                        </td>
                        <td>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6 text-end">
                <h6>Tanggal: 24 Februari 2024 10:00 Wib</h6>
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-menu me-1"></i> Aksi
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Return</a>
                    </li>
                    <li>
                        <a target="_blank" href="{{ url('transaction/pembelian/print/transaction') }}"
                            class="dropdown-item d-flex align-items-center"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Print</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="dropdown-item d-flex align-items-center"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Hapus</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Sub total</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            <tr>
                                <td>1</td>
                                <td>Busi Honda Supra 125 CC</td>
                                <td>25.000</td>
                                <td>1</td>
                                <td>25.000</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td><strong>Total:</strong></td>
                                <td colspan="2" class="text-end"><strong>Rp. 25.000</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td><strong>Bayar:</strong></td>
                                <td colspan="2" class="text-end"><strong>Rp. 50.000</strong></td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td><strong>Kembalian:</strong></td>
                                <td colspan="2" class="text-end"><strong>Rp. 25.000</strong></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row justify-content-end">
            <div class="col-sm-12">
                <x-button-cancel-modal />
                <x-button-submit-modal />
            </div>
        </div>
    </div>
</div>
