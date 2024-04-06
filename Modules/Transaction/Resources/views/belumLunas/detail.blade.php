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
                            supplier
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
                            {{ ucwords($getPembelian['tipe_transaksi']) }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-lg-6 text-end">
                <h6>Tanggal: {{ UtilsHelp::tanggalBulanTahunKonversi($row->transaksi_pembelian) }}</h6>
                @if ($row->jatuhtempo_pembelian)
                    @php
                        $nama_supplier = $row->supplier->nama_supplier ?? 'Supplier Umum';
                        $nowa_supplier = $row->supplier->nowa_supplier ?? '0';
                        $message = $row->keteranganjtempo_pembelian ?? $pesanwa_hutang;
                        $created_at = UtilsHelp::tanggalBulanTahunKonversi($row->transaksi_pembelian);
                        $createdApp = UtilsHelp::createdApp();
                    @endphp
                    <h6 class="m-2 p-0" style="cursor: pointer;" style="font-weight: 800;">
                        <strong class="btn-jatuh-tempo text-danger" data-id="{{ $row->id }}"
                            data-modalid="mediumModal"> JATUH TEMPO:
                            {{ UtilsHelp::formatDate($row->jatuhtempo_pembelian) }} </strong> <br />

                        {!! $row->isinfojtempo_pembelian == 1
                            ? '<strong class="text-primary"> Sudah diingatkan </strong>'
                            : '<strong class="text-primary btn-remember-supplier" data-id="' .
                                $row->id .
                                '">
                                                    <a target="_blank" href="https://wa.me/' .
                                $nowa_supplier .
                                '?text=' .
                                urlencode(
                                    "Kepada Yth: \nSupplier: " .
                                        $nama_supplier .
                                        "\n" .
                                        $message .
                                        "\nterhitung semenjak transaksi dari tanggal " .
                                        $created_at .
                                        ".\nTerimakasih,\nSalam dari " .
                                        $createdApp,
                                ) .
                                '" class="badge bg-success">
                                                        <i class="fa-brands fa-whatsapp me-1"></i> Ingatkan
                                                    </a>
                                                                        </strong>' !!}
                        <strong class="text-primary output_isinfojtempo_pembelian d-none"> Sudah diingatkan </strong>
                    </h6>
                @endif
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

                            @if ($getPembelian['hutang'])
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>Hutang:</strong></td>
                                    <td colspan="1" class="text-end">
                                        {{ UtilsHelp::formatUang($getPembelian['hutang']) }}
                                    </td>
                                </tr>
                            @endif
                            @if ($getPembelian['bayar'])
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>Pembayaran Hutang:</strong></td>
                                    <td colspan="1" class="text-end">
                                        {{ UtilsHelp::formatUang($getPembelian['bayar']) }}
                                    </td>
                                </tr>
                            @endif
                            @if ($getPembelian['cicilan'])
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>Sisa Tagihan:</strong></td>
                                    <td colspan="1" class="text-end">
                                        {{ UtilsHelp::formatUang($getPembelian['cicilan']) }}
                                    </td>
                                </tr>
                            @endif
                            @if ($getPembelian['kembalian'])
                                <tr>
                                    <td colspan="2"></td>
                                    <td><strong>Kembalian:</strong></td>
                                    <td colspan="1" class="text-end">
                                        {{ UtilsHelp::formatUang($getPembelian['kembalian']) }}
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
<script class="url_root" data-value="{{ url('/') }}"></script>
<script src="{{ asset('js/transaction/belumLunas/detail.js') }}"></script>
