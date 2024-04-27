<div class="row">
    <div class="col-lg-12">
        <x-data-customer label="Tanggal Masuk" value="{{ UtilsHelp::tanggalBulanTahunKonversi($row->created_at) }}"
            class="output_created_at" />
        @if ($row->tanggalambil_pservis)
            <x-data-customer label="Tanggal Pengambilan"
                value="{{ UtilsHelp::tanggalBulanTahunKonversi($row->tanggalambil_pservis) }}" />
        @endif
        <x-data-customer labelClass="status_pservis_label"
            label="Status Servis ({{ UtilsHelp::tanggalBulanTahunKonversi($row->updated_at) }})"
            value="{{ ucwords($row->status_pservis) }}" class="output_status_pservis" />
        <x-data-customer label="Penerima / Pembuat Nota Penerimaan Servis" value="{{ ucfirst($row->users->name) }}"
            class="output_name" />
        @if ($row->estimasi_pservis)
            <x-data-customer label="Tanggal Estimasi"
                value="{{ UtilsHelp::formatDateLaporan($row->estimasi_pservis) }}" />
            <x-data-customer label="Keterangan Estimasi" value="{{ $row->keteranganestimasi_pservis }}" />

            @php
                $output_estimasi =
                    '<a href="' .
                    url('service/estimasiServis/remember/' . $row->id . '/estimasi?_method=put') .
                    '"
                        class="btn btn-success btn-remember-estimasi">
                        <i class="fa-brands fa-whatsapp"></i> &nbsp; Ingatkan Customer</a>';

                if ($row->isrememberestimasi_pservis) {
                    $output_estimasi = '
                    <span class="badge bg-primary"><i class="fa-brands fa-whatsapp"></i> Sudah Diingatkan</span>
                    ';
                }
            @endphp
            <x-data-customer label="Ingatkan estimasi servis" value="{!! $output_estimasi !!}" />
        @endif
    </div>
</div>
<hr>
<div class="row">
    <div class="col-lg-12">
        <strong>Detail History Servis</strong>
        <table class="w-100 table mt-3 loadServiceHistory" id="">
            @php
                $no = 1;
            @endphp
            @foreach ($row->serviceHistory as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>
                        {{ UtilsHelp::tanggalBulanTahunKonversi($item->created_at) }}
                    </td>
                    <td>{{ ucwords($item->status_histori) }}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>
