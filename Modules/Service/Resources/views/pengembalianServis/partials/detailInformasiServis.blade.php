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
            </div>
        </div>
        <hr class="">
        <div class="row mb-3">
            <div class="col-lg-12">
                @include('service::pengembalianServis.partials.metodePembayaran')
            </div>
        </div>
        <hr>
        <div class="row mb-3">
            <div class="col-lg-6">
                <div class="row">
                    <div class="col-lg-12">
                        <label for="">Servis Berkala (Datang Kembali):</label>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col-lg-6">
                        <span>{{ $row->nilaiberkala_pservis }}</span>
                    </div>
                    <div class="col-lg-6">
                        <span>{{ $row->tipeberkala_pservis }}</span>
                    </div>
                </div>
                <div style="height: 10px;"></div>
                <div class="form-group mb-3">
                    <label for="">Catatan Teknisi: </label> <br />
                    {{ $row->catatanteknisi_pservis }}
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group mb-3">
                    <label for="">Kondisi Kendaraan Servis: </label> <br />
                    <span>{{ $row->kondisiservis_pservis }}</span>
                </div>
                <div class="form-group mb-3">
                    <label for="">Pesan Whatsapp Servis Berkala: </label> <br />
                    {{ $row->pesanwa_pservis ?? 'Kendaraan Anda Sudah Waktunya Melakukan Servis Berkala sesuai dengan tanggal yang sudah ditentukan dari kami. ' }}
                </div>
            </div>
        </div>
        <hr class="">
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
        <hr>
        <div class="row mb-3">
            <div class="col-lg-12">
                <div class="d-flex justify-content-end">
                    <button type="button" class="btn btn-primary me-2 btn-submit-data" disabled>
                        <i class="fa-solid fa-paper-plane me-2"></i> Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
