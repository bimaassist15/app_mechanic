@php
    $allowedSudahDiambil = ['sudah diambil', 'komplain garansi'];
@endphp
<div>
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
            <x-data-customer label="Status Servis" value="{{ ucwords($row->status_pservis) }}" />
            @php
                $notAllowedStatus = ['bisa diambil', 'tidak bisa', 'cancel', 'sudah diambil', 'komplain garansi'];
            @endphp
            @if (!in_array($row->status_pservis, $notAllowedStatus))
                <div class="hidden_if_status_cancel">
                    <x-form-select-horizontal name="status_pservis" label="Status Servis" :data="$statusKendaraanServis"
                        value="{{ $row->status_pservis }}" />
                </div>
            @endif
        </div>
    </div>

    @php
        $allowed = ['bisa diambil', 'sudah diambil', 'komplain garansi'];
    @endphp

    @if (in_array($row->status_pservis, $allowed))
        @include('service::penerimaanServis.output.metodePembayaran')
    @endif

    @php
        $allowed_servis = [
            'proses servis',
            'bisa diambil',
            'tidak bisa',
            'cancel',
            'sudah diambil',
            'komplain garansi',
        ];
    @endphp
    @if (in_array($row->status_pservis, $allowed_servis))
        <div class="area-proses-servis">
            <hr class="handle-berkala">
            <div class="row mb-3 handle-berkala">
                <div class="col-lg-6">
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <label for="">Servis Berkala (Datang Kembali)</label>
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <input type="number" class="form-control" name="nilaiberkala_pservis"
                                value="{{ $row->nilaiberkala_pservis }}" placeholder="Jumlah servis berkala..."
                                {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}>
                        </div>
                        <div class="col-lg-6">
                            <select name="tipeberkala_pservis" class="form-select" id="tipeberkala_pservis"
                                {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}>
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
                        placeholder="Catatan teknisi..." value="{{ $row->catatanteknisi_pservis }}"
                        disabled="{{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}" />
                </div>
                <div class="col-lg-6">
                    <x-form-input-vertical name="kondisiservis_pservis" label="Kondisi Kendaraan Servis"
                        placeholder="Kondisi kendaraan setelah servis" value="{{ $row->kondisiservis_pservis }}"
                        disabled="{{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}" />
                    <x-form-textarea-vertical label="Pesan Whatsapp Servis Berkala" name="pesanwa_pservis"
                        placeholder="Pesan Whatsapp Servis Berkala..."
                        value="{{ $row->pesanwa_pservis ?? $pesanwa_berkala }}"
                        disabled="{{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}" />
                </div>
            </div>
        </div>
    @endif

    @if (in_array($row->status_pservis, $allowed))
        <div class="row mb-3">
            <div class="col-lg-6 mb-2"></div>
            <div class="col-lg-6 mb-2">
                <label for="">Servis Garansi (Datang Kembali)</label>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6">
                        <input type="number" class="form-control" name="nilaigaransi_pservis"
                            value="{{ $row->nilaigaransi_pservis }}" placeholder="Jumlah servis garansi..."
                            {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}>
                    </div>
                    <div class="col-lg-6">
                        <select name="tipegaransi_pservis" class="form-select" id="tipegaransi_pservis"
                            {{ in_array($row->status_pservis, $allowedSudahDiambil) ? 'disabled' : '' }}>
                            <option selected value="">-- Tipe Garansi --</option>
                            @foreach ($serviceGaransi as $index => $item)
                                @php
                                    $item = (object) $item;
                                @endphp
                                <option value="{{ $item->id }}"
                                    {{ $row->tipegaransi_pservis == $item->id ? 'selected' : '' }}>
                                    {{ $item->label }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @php
        $sudahDiambilAllowed = ['sudah diambil', 'komplain garansi'];
    @endphp

    @if (in_array($row->status_pservis, $sudahDiambilAllowed))
        <hr />
        <div class="row mb-3">
            <div class="col-lg-12">
                <x-form-textarea-vertical label="Keluhan Komplain Garansi Servis" name="garansi_pservis"
                    value="{{ $row->garansi_pservis }}" placeholder="Keluhan Komplain Garansi..." rows="4" />
            </div>
        </div>
    @endif

    <div class="row mb-3 hidden_if_status_cancel">
        <div class="col-lg-12">
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-dark me-2">
                    <i class="fa-solid fa-list-check me-2"></i> {{ ucwords($row->status_pservis) }}
                </button>

                <button type="button" class="btn btn-info me-2 btn-print-data"
                    data-tipe="@if (in_array($row->status_pservis, $sudahDiambilAllowed)) selesai @else belum selesai @endif">
                    <i class="fa-solid fa-print me-2"></i> Print Data
                </button>
                <button type="button" class="btn btn-primary me-2 btn-submit-data">
                    <i class="fa-solid fa-paper-plane me-2"></i> Submit
                </button>
            </div>
        </div>
    </div>
</div>
