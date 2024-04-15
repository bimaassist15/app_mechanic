@php
    $no = 1;
    $totalHargaServis = $row->orderServis->sum('harga_orderservis');
    $allowedSudahDiambil = ['sudah diambil', 'komplain garansi'];

@endphp

@foreach ($row->orderServis as $item)
    @php
        $kategoriServis = $item->hargaServis->kategoriServis;
        $hargaServis = $item->hargaServis;
        $usersMekanik = $item->usersMekanik;
    @endphp
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $kategoriServis->nama_kservis }}</td>
        <td>{{ $hargaServis->nama_hargaservis }}</td>
        <td>{{ $usersMekanik->name ?? '-' }}</td>
        <td>{{ UtilsHelp::formatUang($hargaServis->total_hargaservis) }}</td>
        <td>
            <button data-urlcreate="{{ url('/service/orderServis/' . $item->id . '/edit') }}" data-typemodal="mediumModal"
                class="btn btn-primary update-users-mekanik btn-small" title="Masukan Data Mekanik"
                {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}>
                <i class="fa-solid fa-wrench"></i>
            </button>
            <button data-urlcreate="{{ url('/service/orderServis/' . $item->id . '?_method=delete') }}"
                data-id="{{ $item->id }}" class="btn btn-danger delete-order-servis btn-small"
                title="Delete Order Servis" {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}>
                <i class="fa-solid fa-trash"></i>
            </button>
        </td>
    </tr>
@endforeach
<tr id="load_viewdata_orderservis" class="text-center d-none">
    <td colspan="6">
        <div>
            <div>
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            <strong>Loading...</strong>
        </div>
    </td>
</tr>
<tr>
    <td colspan="4" class="text-end">
        <strong>Total Biaya Jasa</strong>
    </td>
    <td>
        <span class="totalHargaServis">{{ UtilsHelp::formatUang($totalHargaServis) }}</span>
    </td>
    <td></td>
</tr>
