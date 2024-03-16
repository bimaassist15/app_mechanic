@php
    $getPenjualan = UtilsHelp::paymentStatisPenjualan($row->id);
@endphp
<div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-6">
                <table class="w-100">
                    <tr>
                        <td colspan="2">
                            <h4><i class="fa-solid fa-globe"></i> No. Invoice:
                                {{ $row->invoice_penjualan }}</h4>
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
                            <strong>{{ $row->customer->nama_customer ?? 'Umum' }}</strong>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            {{ UtilsHelp::myCabang()->alamat_cabang }}
                        </td>
                        <td>
                            {{ $row->customer->nama_customer ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Telp/Wa:
                            {{ UtilsHelp::myCabang()->nowa_cabang }}/{{ UtilsHelp::myCabang()->notelpon_cabang }}
                        </td>
                        <td>
                            Telp/Wa: {{ $row->customer->nowa_customer ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Email: {{ UtilsHelp::myCabang()->email_cabang }}
                        </td>
                        <td>
                            Email: {{ $row->customer->email_customer ?? '-' }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Kasir: {{ $row->users->profile->nama_profile }}
                        </td>
                        <td>
                            Tipe Transaksi: {{ ucwords($getPenjualan['tipe_transaksi']) }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6 text-end">
                <h6>Tanggal: {{ UtilsHelp::tanggalBulanTahunKonversi($row->transaksi_penjualan) }}</h6>
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <i class="bx bx-menu me-1"></i> Aksi
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a href="{{ url('purchase/kasir?penjualan_id=' . $row->id . '&isEdit=true') }}"
                            class="dropdown-item d-flex align-items-center btn-edit-transaksi"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Edit Transaksi</a>
                    </li>
                    <li>
                        <a target="_blank" href="{{ url('purchase/penjualan/print/purchase') }}"
                            class="dropdown-item d-flex align-items-center btn-print"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Print</a>
                    </li>
                    <li>
                        <a href="{{ url('purchase/penjualan/' . $row->id . '?_method=delete') }}"
                            class="dropdown-item d-flex align-items-center btn-delete"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Hapus</a>
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
                            @foreach ($row->penjualanProduct as $item)
                                <tr>
                                    <td>{{ $item->barang->nama_barang }}</td>
                                    <td>{{ UtilsHelp::formatUang($item->barang->hargajual_barang) }}</td>
                                    <td>{{ $item->jumlah_penjualanproduct }}</td>
                                    <td>{{ UtilsHelp::formatUang($item->subtotal_penjualanproduct) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2"></td>
                                <td><strong>Total:</strong></td>
                                <td colspan="1" class="text-end">
                                    <strong>{{ UtilsHelp::formatUang($row->total_penjualan) }}</strong>
                                </td>
                            </tr>

                            @foreach ($row->penjualanPembayaran as $item)
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>{{ $item->kategoriPembayaran->nama_kpembayaran }}</strong></td>
                                    <td colspan="1" class="text-end">
                                        {{ UtilsHelp::formatUang($item->bayar_ppembayaran) }}
                                    </td>
                                </tr>
                            @endforeach
                            @if ($getPenjualan['hutang'])
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>Hutang:</strong></td>
                                    <td colspan="1" class="text-end">
                                        {{ UtilsHelp::formatUang($getPenjualan['hutang']) }}
                                    </td>
                                </tr>
                            @endif
                            @if (!$getPenjualan['hutang'])
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>Kembalian:</strong></td>
                                    <td colspan="1" class="text-end">
                                        <strong>{{ UtilsHelp::formatUang($getPenjualan['kembalian']) }}</strong>
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

<script class="penjualan_id" data-value="{{ $row->id }}"></script>
<script class="json_row" data-value="{{ $jsonRow }}"></script>
<script src="{{ asset('js/purchase/penjualan/detail.js') }}"></script>
