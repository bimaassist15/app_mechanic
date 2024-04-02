<div class="mb-3">
    <table class="table table-bordered">
        <tr>
            <th colspan="2">
                <strong>
                    1. Pendapatan
                </strong>
            </th>
        </tr>
        <tr>
            <td>1. Penjualan</td>
            <td>Rp. {{ UtilsHelp::formatUang($pendapatan['penjualan']) }}</td>
        </tr>
        <tr>
            <td>2. Servis</td>
            <td>Rp. {{ UtilsHelp::formatUang($pendapatan['servis']) }}</td>
        </tr>
        @php
            $no = 3;
        @endphp
        @foreach ($pendapatan['data_pendapatan'] as $item)
            <tr>
                <td>{{ $no++ }}. {{ $item->nama_kpendapatan }}</td>
                <td>Rp. {{ UtilsHelp::formatUang($item->jumlah_tpendapatan) }}</td>
            </tr>
        @endforeach
        <tr>
            <td>
                <strong>Total Pendapatan</strong>
            </td>
            <td>
                <strong>
                    Rp. {{ UtilsHelp::formatUang($pendapatan['total_pendapatan']) }}
                </strong>
            </td>
        </tr>
    </table>
</div>
