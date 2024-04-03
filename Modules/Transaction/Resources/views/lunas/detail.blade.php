@php
    $getPembelian = UtilsHelp::paymentStatisPembelian($row->id);
@endphp
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
                            Tipe Transaksi: {{ ucwords($getPembelian['tipe_transaksi']) }}
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
                        <a target="_blank" href="{{ url('transaction/pembelianCicilan/print/transaction') }}"
                            class="dropdown-item d-flex align-items-center btn-print"><i
                                class="bx bx-chevron-right scaleX-n1-rtl"></i>Print</a>
                    </li>
                </ul>
            </div>

            <div class="col-lg-12 mt-3">
                <div class="table-responsive text-nowrap px-3">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Pembayaran</th>
                                <th>Bayar</th>
                                <th>Kembalian</th>
                                <th>Hutang</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($row->pembelianCicilan as $item)
                                <tr>
                                    <td>
                                        {{ $item->subPembayaran->nama_spembayaran }}
                                    </td>
                                    <td>{{ UtilsHelp::formatUang($item->bayar_pbcicilan) }}</td>
                                    <td>{{ UtilsHelp::formatUang($item->kembalian_pbcicilan) }}</td>
                                    <td>{{ UtilsHelp::formatUang($item->hutang_pbcicilan) }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td>Total Hutang</td>
                                <td style="padding: 0 80px;">Rp. &emsp;: </td>
                                <td>{{ UtilsHelp::formatUang($getPembelian['hutang']) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Total Pembayaran</td>
                                <td style="padding: 0 80px;">Rp. &emsp;: </td>
                                <td>{{ UtilsHelp::formatUang($getPembelian['bayar']) }}</td>
                            </tr>
                            @if (!$getPembelian['status_transaksi'])
                                <tr>
                                    <td></td>
                                    <td>Hutang</td>
                                    <td style="padding: 0 80px;">Rp. &emsp;: </td>
                                    <td>{{ UtilsHelp::formatUang($getPembelian['cicilan']) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <td>Kembalian</td>
                                <td style="padding: 0 80px;">Rp. &emsp;:</td>
                                <td>{{ UtilsHelp::formatUang($getPembelian['kembalian']) }} </td>
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
                <x-button-ok-modal />
            </div>
        </div>
    </div>
</div>

<script class="pembelian_id" data-value="{{ $row->id }}"></script>
<script class="json_row" data-value="{{ $jsonRow }}"></script>
<script class="url_transaction_kasir"
    data-url="{{ url('transaction/pembelianCicilan/create?pembelian_id=' . $row->id) }}"></script>
<script src="{{ asset('js/transaction/pembelianCicilan/detail.js') }}"></script>
