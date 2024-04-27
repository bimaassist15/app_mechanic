@php
    $allowedSudahDiambil = ['sudah diambil', 'komplain garansi'];
@endphp
<div class="card mt-4">
    <div class="card-header">
        Informasi Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
            {{ $row->nonota_pservis }}</strong>
    </div>
    <div class="card-body">
        <div id="load_output_informasi_servis" class="text-center d-none">
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
        </div>
        <div class="output_informasi_servis">
            @include('service::penerimaanServis.output.informasiServis')
        </div>
    </div>
</div>
