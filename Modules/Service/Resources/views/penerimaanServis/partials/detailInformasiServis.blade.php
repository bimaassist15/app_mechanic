<div class="card mt-4">
    <div class="card-header">
        Informasi Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
            {{ $row->nonota_pservis }}</strong>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-lg-6">
                <x-data-customer label="Sub Total" value="{{ UtilsHelp::formatUang($row->totalbiaya_pservis) }}"
                    class="output_totalbiaya_pservis" />
                <x-data-customer label="Hutang" value="{{ UtilsHelp::formatUang($row->hutang_pservis) }}"
                    class="output_hutang_pservis" />
            </div>
            <div class="col-lg-6">
                <x-data-customer label="Deposit" value="{{ UtilsHelp::formatUang($row->total_dppservis) }}"
                    class="output_total_dppservis" />
                <div class="hidden_if_status_cancel">
                    <x-form-select-horizontal name="status_pservis" label="Status Servis" :data="$statusKendaraanServis"
                        value="{{ $row->status_pservis }}" />
                </div>
                <div class="display_if_status_cancel d-none">
                    <span class="output_status_pservis">{{ $row->status_pservis }}</span>
                </div>
            </div>
        </div>
        <hr class="handle-berkala d-none">
        <div class="row mb-3 handle-berkala d-none">
            <div class="col-lg-6">
                <div class="row mb-2">
                    <div class="col-lg-12">
                        <label for="">Servis Berkala (Datang Kembali)</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-6">
                        <input type="number" class="form-control" name="nilaiberkala_pservis"
                            value="{{ $row->nilaiberkala_pservis }}" placeholder="Jumlah servis berkala...">
                    </div>
                    <div class="col-lg-6">
                        <select name="tipeberkala_pservis" class="form-select" id="tipeberkala_pservis">
                            <option selected value="">-- Tipe Servis Berkala --</option>
                            @foreach ($serviceBerkala as $index => $item)
                                @php
                                    $item = (object) $item;
                                @endphp
                                <option value="{{ $item->id }}"
                                    {{ $row->tipeberkala_pservis == $item->id ? 'selected' : '' }}>
                                    {{ $item->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div style="height: 10px;"></div>
                <x-form-textarea-vertical label="Catatan Teknisi" name="catatanteknisi_pservis"
                    placeholder="Catatan teknisi..." value="{{ $row->catatanteknisi_pservis }}" />
            </div>
            <div class="col-lg-6">
                <x-form-input-vertical name="kondisiservis_pservis" label="Kondisi Kendaraan Servis"
                    placeholder="Kondisi kendaraan setelah servis" value="{{ $row->kondisiservis_pservis }}" />
                <x-form-textarea-vertical label="Pesan Whatsapp Servis Berkala" name="pesanwa_pservis"
                    placeholder="Pesan Whatsapp Servis Berkala..."
                    value="{{ $row->pesanwa_pservis ?? $pesanwa_berkala }}" />
            </div>
        </div>
        <div class="row mb-3 hidden_if_status_cancel">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-info me-2 btn-print-data">
                        <i class="fa-solid fa-print me-2"></i> Print Data
                    </button>
                    <button type="button" class="btn btn-primary me-2 btn-submit-data">
                        <i class="fa-solid fa-paper-plane me-2"></i> Submit
                    </button>
                </div>
            </div>
        </div>
        <div class="row mb-3 display_if_status_cancel d-none">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end">
                    <h5 class="text-danger badge bg-danger text-white">
                        Transaksi Ini Dibatalkan
                    </h5>
                </div>
            </div>
        </div>
    </div>
</div>
