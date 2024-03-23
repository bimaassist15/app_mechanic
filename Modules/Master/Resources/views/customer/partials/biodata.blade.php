<div class="mb-3">
    <div class="row mb-3">
        <div class="col-lg-12 bg-primary" style="border-radius: 5px;">
            <h5 class="m-0 text-white p-2">
                Biodata Customer
            </h5>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
            <x-data-horizontal label="Nama Lengkap" value="{{ isset($row) ? $row->nama_customer ?? '' : '' }}" />

            <x-data-horizontal label="Nomor Whatsapp" value="{{ isset($row) ? $row->nowa_customer ?? '' : '' }}" />
            <x-data-horizontal label="Email" value="{{ isset($row) ? $row->email_customer ?? '' : '' }}" />

        </div>
        <div class="col-lg-6">
            <x-data-horizontal label="Alamat" value="{{ isset($row) ? $row->alamat_customer ?? '' : '' }}" />
            @php
                $status = isset($row)
                    ? ($row->status_customer == true
                        ? '<i class="fa-solid fa-check"></i>'
                        : '<i class="fa-solid fa-circle-xmark"></i>')
                    : '';
            @endphp
            <x-data-horizontal label="Status" value="{!! $status !!}" />
            <x-data-horizontal label="Waktu Register"
                value="{{ UtilsHelp::tanggalBulanTahunKonversi($row->created_at) }}" />
            <x-data-horizontal label="Pembelian" value="{{ $row->penjualan_count }} x" />
            <x-data-horizontal label="Servis" value="{{ $row->penerimaan_servis_count }} x" />

        </div>
    </div>
</div>
