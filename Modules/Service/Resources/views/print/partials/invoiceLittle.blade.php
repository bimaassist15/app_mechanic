<table class="w-100">
    <tr>
        <td style="width: 80%; text-align: right;">Total Biaya</td>
        <td>:</td>
        <td style="width: 20%; text-align: right;">{{ UtilsHelp::formatUang($row->totalbiaya_pservis) }}</td>
    </tr>
    @php
        $pembayaranServis = $row->pembayaranServis;
        $is_deposit = false;
        $dataPembayaranServis = $row->pembayaranServis;
        foreach ($pembayaranServis as $key => $item) {
            if (strtolower($item->kategoriPembayaran->nama_kpembayaran) === 'deposit') {
                $is_deposit = true;
            }
        }
        if ($is_deposit) {
            $is_deposit2 = false;
            $dataPembayaranServis = [];
            foreach ($pembayaranServis as $key => $item) {
                if (strtolower($item->kategoriPembayaran->nama_kpembayaran) === 'deposit') {
                    $is_deposit2 = true;
                }

                if ($is_deposit2) {
                    $dataPembayaranServis[] = $item;
                }
            }
        }
    @endphp
    @foreach ($dataPembayaranServis as $item)
        <tr>
            <td style="width: 80%; text-align: right;">{{ $item->kategoriPembayaran->nama_kpembayaran }}</td>
            <td>:</td>
            <td style="width: 20%; text-align: right;">
                {{ $item->deposit_pservis != null ? UtilsHelp::formatUang($item->deposit_pservis) : UtilsHelp::formatUang($item->bayar_pservis) }}
            </td>
        </tr>
    @endforeach
    <tr>
        <td style="width: 80%; text-align: right;">Kembalian</td>
        <td>:</td>
        <td style="width: 20%; text-align: right;">{{ UtilsHelp::formatUang($row->kembalian_pservis) }}</td>
    </tr>
    @if ($row->hutang_pservis)
        <tr>
            <td style="width: 80%; text-align: right;">Hutang</td>
            <td>:</td>
            <td style="width: 20%; text-align: right;">{{ UtilsHelp::formatUang($row->hutang_pservis) }}</td>
        </tr>
    @endif
</table>
