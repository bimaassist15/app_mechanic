<div class="card mt-4">
    <div class="card-header">
        Informasi Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
            {{ $row->nonota_pservis }}</strong>
    </div>
    <div class="card-body">
        <div class="row mb-3">
            <div class="col-lg-6">
                <x-data-customer label="Total Biaya" value="{{ UtilsHelp::formatUang($row->totalbiaya_pservis) }}"
                    class="output_totalbiaya_pservis" />
                <x-data-customer label="Hutang" value="{{ UtilsHelp::formatUang($row->hutang_pservis) }}"
                    class="output_hutang_pservis" />
            </div>
            <div class="col-lg-6">
                <x-data-customer label="Deposit" value="{{ UtilsHelp::formatUang($row->total_dppservis) }}"
                    class="output_total_dppservis" labelClass="label_total_dppservis" />
                <x-data-customer label="Bayar" value="{{ UtilsHelp::formatUang($row->bayar_pservis) }}"
                    class="output_bayar_pservis" />
                <x-data-customer label="Kembalian" value="{{ UtilsHelp::formatUang($row->kembalian_pservis) }}"
                    class="output_kembalian_pservis" />

            </div>
        </div>
        <hr class="">
        <div class="row mb-3">
            <div class="col-lg-12">
                @include('service::kendaraanServis.partialsPengembalian.metodePembayaran')
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-lg-6">
                <div class="row mb-2">
                    <div class="col-lg-12">
                        <label for="">Servis Berkala (Datang Kembali)</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-6">
                        <span class="output_nilaiberkala_pservis">
                            {{ $row->nilaiberkala_pservis }}
                        </span>
                    </div>
                    <div class="col-lg-6">
                        <span class="output_tipeberkala_pservis">{{ $row->tipeberkala_pservis }}</span>
                    </div>
                </div>
                <div style="height: 10px;"></div>
                <div class="form-group mb-3">
                    <label for="">Catatan Teknisi: </label> <br />
                    <span class="output_catatanteknisi_pservis">
                        {{ $row->catatanteknisi_pservis }}
                    </span>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group mb-3">
                    <label for="">Kondisi Kendaraan Servis: </label> <br />
                    <span class="output_kondisiservis_pservis">{{ $row->kondisiservis_pservis }}</span>
                </div>
                <div class="form-group mb-3">
                    <label for="">Pesan Whatsapp Servis Berkala: </label> <br />
                    <span
                        class="output_pesanwa_pservis">{{ $row->pesanwa_pservis ?? $pesanwa_berkala }}</span>
                </div>
            </div>
        </div>
        <hr class="">
        <div class="row mb-3 hidden_tanggal_diambil">
            <div class="col-lg-6 mb-2"></div>
            <div class="col-lg-6 mb-2">
                <label for="">Servis Garansi (Datang Kembali): </label>
            </div>
            <div class="col-lg-6"></div>
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-6">
                        <input type="number" class="form-control" name="nilaigaransi_pservis"
                            value="{{ $row->nilaigaransi_pservis }}" placeholder="Jumlah servis garansi...">
                    </div>
                    <div class="col-lg-6">
                        <select name="tipegaransi_pservis" class="form-select" id="tipegaransi_pservis">
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
        <div class="row mb-3 hidden_tanggal_diambil">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-2 btn-submit-data" disabled>
                        <i class="fa-solid fa-paper-plane me-2"></i> Submit
                    </button>
                </div>
            </div>
        </div>
        <div class="display_after_bisa_diambil d-none">
            <div class="row mb-3">
                <div class="col-lg-6 mb-2"></div>
                <div class="col-lg-6 mb-2">
                    <label for="">Servis Garansi (Datang Kembali): </label>
                </div>
                <div class="col-lg-6"></div>
                <div class="col-lg-6">
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <span class="output_nilaigaransi_pservis">{{ $row->nilaigaransi_pservis }}</span>
                        </div>
                        <div class="col-lg-6">
                            <span class="output_tipegaransi_pservis">{{ $row->tipegaransi_pservis }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <strong class="output_servisgaransi_pservis">
                                <x-data-vertical label="Garansi Sampai dengan:"
                                    value="{{ UtilsHelp::formatDate($row->servisgaransi_pservis) }}" />
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
            <hr class="">
            <div class="row mb-3">
                <div class="col-lg-12">
                    Garansi Kendaraan <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
                        {{ $row->nonota_pservis }}</strong>
                </div>
            </div>
            <hr>
            <div class="row hidden_garansi_pservis">
                <div class="col-lg-6">
                    <x-form-textarea-vertical label="Keluhan Komplain Garansi Servis" name="garansi_pservis"
                        value="{{ $row->garansi_pservis }}" placeholder="Keluhan Komplain Garansi..."
                        rows="4" />
                </div>
                <div class="col-lg-6"></div>
            </div>
            <div class="row display_garansi_pservis d-none">
                <div class="col-lg-6">
                    <x-data-vertical label="<strong>Komplain Garansi:</strong>"
                        value="<span class='output_garansi_pservis'>{{ $row->garansi_pservis }}</span>" />
                </div>
                <div class="col-lg-6">
                    <x-data-vertical label="<strong>Penerima Komplain:</strong>"
                        value="<span class='output_users_id_garansi'>{{ ucfirst(e($row->usersIdGaransi->name ?? '-')) }}</span>" />
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-lg-12">
                    <div class="d-flex justify-content-end">
                        <button type="button" class="btn btn-dark me-2 if_status_cancel d-none">
                            <i class="fa-solid fa-pen me-2"></i> {{ ucfirst($row->status_pservis) }}
                        </button>
                        <button type="button" class="btn btn-primary me-2 btn-print-data">
                            <i class="fa-solid fa-print me-2"></i> Print Nota
                        </button>
                        <button type="button" class="btn btn-primary me-2 btn-complain hidden_garansi_pservis">
                            <i class="fa-solid fa-paper-plane me-2"></i>
                            Submit
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
