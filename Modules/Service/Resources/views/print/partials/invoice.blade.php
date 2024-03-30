<table class="w-100">
    <td style="vertical-align: top; width: 35%;">
        <table class="w-100">
            <tr>
                <td style="width: 80%;">Total Biaya</td>
                <td>:</td>
                <td style="width: 20%;">{{ UtilsHelp::formatUang($row->totalbiaya_pservis) }}</td>
            </tr>
            @foreach ($row->pembayaranServis as $item)
                @if ($loop->first && count($row->pembayaranServis) > 1)
                    @continue
                @endif
                <tr>
                    <td style="width: 80%;">{{ $item->kategoriPembayaran->nama_kpembayaran }}</td>
                    <td>:</td>
                    <td style="width: 20%;">
                        {{ $item->deposit_pservis != null ? UtilsHelp::formatUang($item->deposit_pservis) : UtilsHelp::formatUang($item->bayar_pservis) }}
                    </td>
                </tr>
            @endforeach
            <tr>
                <td style="width: 80%;">Kembalian</td>
                <td>:</td>
                <td style="width: 20%;">{{ UtilsHelp::formatUang($row->kembalian_pservis) }}</td>
            </tr>
            @if ($row->hutang_pservis)
                <tr>
                    <td style="width: 80%;">Hutang</td>
                    <td>:</td>
                    <td style="width: 20%;">{{ UtilsHelp::formatUang($row->hutang_pservis) }}</td>
                </tr>
            @endif
        </table>
    </td>
    <td style="vertical-align: top; width: 65%">
        <table class="w-100">
            <tr>
                <td class="v-align-top text-center" style="padding-right: 25px;">
                    <table class="w-100">
                        <tr>
                            <td><strong>CUSTOMER</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <div style="height: 50px;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="width: 100%; height: 1px; background-color: black;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ ucwords($row->customer->nama_customer) }}
                            </td>
                        </tr>
                    </table>
                </td>
                <td class="v-align-top text-center" style="padding-left: 25px;">
                    <table class="w-100">
                        <tr>
                            <td><strong>PENYERAH</strong></td>
                        </tr>
                        <tr>
                            <td>
                                <div style="height: 50px;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <div style="width: 100%; height: 1px; background-color: black;"></div>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                {{ ucwords(Auth::user()->name) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </td>
</table>
