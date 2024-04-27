<div class="card mt-4">
    <div class="card-header">
        History Servis <strong style="font-weight: 800; color:rgb(102, 102, 230);">No. Nota
            {{ $row->nonota_pservis }}</strong>
    </div>
    <div id="load_view_data_history" class="text-center d-none">
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
    <div class="card-body output_data_history">
        @include('service::penerimaanServis.output.histori')
    </div>
</div>
