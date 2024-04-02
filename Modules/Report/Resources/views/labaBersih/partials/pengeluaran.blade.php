<div class="mb-3">
    <table class="table table-bordered">
        <tr>
            <th colspan="2">
                <strong>3. Biaya Pengeluaran</strong>
            </th>
        </tr>
        @php
            $no = 1;
        @endphp
        @foreach ($pengeluaran as $item)
            <tr>
                <td>{{ $no++ }}. {{ $item->nama_kpengeluaran }}</td>
                <td>Rp. {{ UtilsHelp::formatUang($item->jumlah_tpengeluaran) }}</td>
            </tr>
        @endforeach
        <tr>
            <td>
                <strong>Total Biaya Pengeluaran</strong>
            </td>
            <td>
                <strong>
                    Rp. {{ UtilsHelp::formatUang($total_pengeluaran) }}
                </strong>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Laba Bersih</strong>
            </td>
            <td>
                <strong>
                    Rp. {{ UtilsHelp::formatUang($laba_bersih) }}
                </strong>
            </td>
        </tr>
    </table>
</div>
