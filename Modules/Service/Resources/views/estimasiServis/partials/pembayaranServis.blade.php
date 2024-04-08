<div class="card mb-3 {{ $row->isdp_pservis ? '' : 'hidden' }}">
    <div class="card-header bg-primary text-white p-3 mb-3 mt-3">
        <strong>Deposit Servis</strong>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach ($row->pembayaranServis as $item)
                @if (strtolower($item->kategoriPembayaran->nama_kpembayaran) == 'langsung')
                    <div class="col-lg-3 mb-2">
                        <x-data-vertical label="Kategori Pembayaran"
                            value="{{ $item->kategoriPembayaran->nama_kpembayaran }}" />
                    </div>
                    <div class="col-lg-3 mb-2">
                        <x-data-vertical label="Sub Pembayaran" value="{{ $item->subPembayaran->nama_spembayaran }}" />
                    </div>
                    <div class="col-lg-3 mb-2">
                        <x-data-vertical label="Jumlah Deposit"
                            value="{{ UtilsHelp::formatUang($item->deposit_pservis) }}" />
                    </div>
                    <div class="col-lg-3 mb-2">
                        <x-data-vertical label="Bayar" value="{{ UtilsHelp::formatUang($item->bayar_pservis) }}" />
                    </div>
                    <div class="col-lg-3 mb-2">
                        <x-data-vertical label="Dibayar Oleh" value="{{ $item->dibayaroleh_pservis }}" />
                    </div>
                    <div class="col-lg-3 mb-2">
                        <x-data-vertical label="Kasir" value="{{ $item->users->name }}" />
                    </div>
                    <div class="col-lg-3 mb-2">
                        <x-data-vertical label="Kembalian"
                            value="{{ UtilsHelp::formatUang($item->kembalian_pservis) }}" />
                    </div>
                    <div class="col-lg-3 mb-2">
                        <x-data-vertical label="Hutang" value="{{ UtilsHelp::formatUang($item->hutang_pservis) }}" />
                    </div>
                    <hr />
                @else
                    @if (strtolower($item->kategoriPembayaran->nama_kpembayaran) != 'deposit' &&
                            strtolower($item->kategoriPembayaran->nama_kpembayaran) != 'langsung')
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Kategori Pembayaran"
                                value="{{ $item->kategoriPembayaran->nama_kpembayaran }}" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Sub Pembayaran"
                                value="{{ $item->subPembayaran->nama_spembayaran }}" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Nama Kartu" value="{{ $item->pemilikkartu_pservis }}" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Nomor Kartu" value="{{ $item->nomorkartu_pservis }}" />
                        </div>
                        <div class="col-lg-3 mb-2"></div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Kasir" value="{{ $item->users->name }}" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Bayar"
                                value="{{ UtilsHelp::formatUang($item->bayar_pservis) }}" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Hutang"
                                value="{{ UtilsHelp::formatUang($item->hutang_pservis) }}" />
                        </div>
                        <hr />
                    @endif
                    @if (strtolower($item->kategoriPembayaran->nama_kpembayaran) == 'deposit')
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Kategori Pembayaran"
                                value="{{ $item->kategoriPembayaran->nama_kpembayaran }}" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Sub Pembayaran" value="-" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Saldo Deposit"
                                value="{{ UtilsHelp::formatUang($item->saldodeposit_pservis) }}" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Bayar"
                                value="{{ UtilsHelp::formatUang($item->bayar_pservis) }}" />
                        </div>
                        <div class="col-lg-3 mb-2"></div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Kembalian"
                                value="{{ UtilsHelp::formatUang($item->kembalian_pservis) }}" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Sisa Saldo"
                                value="{{ UtilsHelp::formatUang($item->deposit_pservis) }}" />
                        </div>
                        <div class="col-lg-3 mb-2">
                            <x-data-vertical label="Hutang"
                                value="{{ UtilsHelp::formatUang($item->hutang_pservis) }}" />
                        </div>
                        <hr />
                    @endif
                @endif
            @endforeach
        </div>
    </div>
</div>
