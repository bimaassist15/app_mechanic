<div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <table class="w-100">
                    <tr>
                        <td colspan="2">
                            <h4><i class="fa-solid fa-globe"></i> No. Invoice:
                                {{ $row->invoice_pembelian }}</h4>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Dari
                        </td>
                        <td>
                            Customer
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <strong>{{ UtilsHelp::myCabang()->bengkel_cabang }}</strong>
                        </td>
                        <td>
                            <strong>{{ $row->supplier->nama_supplier ?? 'Umum' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ UtilsHelp::myCabang()->alamat_cabang }}
                        </td>
                        <td>
                            {{ $row->supplier->nama_supplier ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Telp/Wa:
                            {{ UtilsHelp::myCabang()->nowa_cabang }}/{{ UtilsHelp::myCabang()->notelpon_cabang }}
                        </td>
                        <td>
                            Telp/Wa: {{ $row->supplier->nowa_supplier ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email: {{ UtilsHelp::myCabang()->email_cabang }}
                        </td>
                        <td>
                            Email: {{ $row->supplier->email_supplier ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Kasir: {{ $row->users->profile->nama_profile }}
                        </td>
                        <td>
                            Tipe Transaksi:
                            {{ count($row->pembelianCicilan) > 0 ? 'Hutang' : ucwords($row->tipe_pembelian) }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6 text-end">
                <h6>Tanggal: {{ UtilsHelp::tanggalBulanTahunKonversi($row->transaksi_pembelian) }}</h6>
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-menu me-1"></i> Aksi
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a target="_blank" href="{{ url('transaction/pembelian/print/transaction') }}"
                            class="dropdown-item d-flex align-items-center btn-print"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Print</a>
                    </li>
                    <li>
                        <a href="{{ url('transaction/pembelianCicilan?pembelian_id=' . $row->id) }}"
                            class="dropdown-item d-flex align-items-center"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Bayar Tagihan</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table" id="dataTable">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Qty</th>
                                <th>Sub total</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @foreach ($row->pembelianProduct as $item)
                                <tr>
                                    <td>{{ $item->barang->nama_barang }}</td>
                                    <td>{{ UtilsHelp::formatUang($item->barang->hargajual_barang) }}</td>
                                    <td>{{ $item->jumlah_pembelianproduct }}</td>
                                    <td>{{ UtilsHelp::formatUang($item->subtotal_pembelianproduct) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td><strong>Total:</strong></td>
                                <td colspan="1" class="text-end">
                                    <strong>{{ UtilsHelp::formatUang($row->total_pembelian) }}</strong>
                                </td>
                            </tr>

                            @foreach ($row->pembelianPembayaran as $item)
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>{{ $item->kategoriPembayaran->nama_kpembayaran }}</strong></td>
                                    <td colspan="1" class="text-end">
                                        {{ UtilsHelp::formatUang($item->bayar_pbpembayaran) }}
                                    </td>
                                </tr>
                            @endforeach

                            @if (count($row->pembelianCicilan) == 0)
                                @if ($row->hutang_pembelian)
                                    <tr>
                                        <td colspan="2"></td>
                                        <td><strong>Hutang:</strong></td>
                                        <td colspan="1" class="text-end">
                                            {{ UtilsHelp::formatUang($row->hutang_pembelian) }}
                                        </td>
                                    </tr>
                                @endif
                            @endif

                            @if (count($row->pembelianCicilan) > 0)
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>Hutang:</strong></td>
                                    <td colspan="1" class="text-end">
                                        {{ UtilsHelp::formatUang($row->pembelianCicilan[0]->bayar_pbcicilan + $row->pembelianCicilan[0]->hutang_pbcicilan) }}
                                    </td>
                                </tr>
                            @endif

                            @if (count($row->pembelianCicilan) == 0)
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>Kembalian:</strong></td>
                                    <td colspan="1" class="text-end">
                                        <strong>{{ UtilsHelp::formatUang($row->kembalian_pembelian) }}</strong>
                                    </td>
                                </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <div class="row justify-content-end">
            <div class="col-sm-12">
                <x-button-ok-modal />
            </div>
        </div>
    </div>
</div>

<script class="pembelian_id" data-value="{{ $row->id }}"></script>
<script src="{{ asset('js/transaction/belumLunas/detail.js') }}"></script>
