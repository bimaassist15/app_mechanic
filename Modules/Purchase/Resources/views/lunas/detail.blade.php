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
                        <a target="_blank" href="{{ url('purchase/penjualanCicilan/print/purchase') }}"
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
                            @foreach ($row->penjualanCicilan as $item)
                                <tr>
                                    <td>
                                        {{ $item->subPembayaran->nama_spembayaran }}
                                    </td>
                                    <td>{{ UtilsHelp::formatUang($item->bayar_pcicilan) }}</td>
                                    <td>{{ UtilsHelp::formatUang($item->kembalian_pcicilan) }}</td>
                                    <td>{{ UtilsHelp::formatUang($item->hutang_pcicilan) }}</td>
                                </tr>
                            @endforeach

                        </tbody>
                        <tfoot>
                            <tr>
                                <td></td>
                                <td>Total Hutang</td>
                                <td style="padding: 0 80px;">Rp. &emsp;: </td>
                                <td>{{ UtilsHelp::formatUang($getPenjualan['hutang']) }}</td>
                            </tr>
                            <tr>
                                <td></td>
                                <td>Total Pembayaran</td>
                                <td style="padding: 0 80px;">Rp. &emsp;: </td>
                                <td>{{ UtilsHelp::formatUang($getPenjualan['bayar']) }}</td>
                            </tr>
                            @if (!$getPenjualan['status_transaksi'])
                                <tr>
                                    <td></td>
                                    <td>Hutang</td>
                                    <td style="padding: 0 80px;">Rp. &emsp;: </td>
                                    <td>{{ UtilsHelp::formatUang($getPenjualan['cicilan']) }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td></td>
                                <td>Kembalian</td>
                                <td style="padding: 0 80px;">Rp. &emsp;:</td>
                                <td>{{ UtilsHelp::formatUang($getPenjualan['kembalian']) }} </td>
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

<script class="penjualan_id" data-value="{{ $row->id }}"></script>
<script class="json_row" data-value="{{ $jsonRow }}"></script>
<script class="url_purchase_kasir" data-url="{{ url('purchase/penjualanCicilan/create?penjualan_id=' . $row->id) }}">
</script>
<script src="{{ asset('js/purchase/penjualanCicilan/detail.js') }}"></script>
