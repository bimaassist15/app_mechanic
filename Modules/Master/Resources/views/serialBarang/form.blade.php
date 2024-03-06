<div>
    <form id="form-submit" action="{{ $action }}">
        <div class="modal-body">
            @if ($formCount == 0)
                <h5>Serial Number sudah memenuhi stok barang</h5>
            @else
                @for ($i = 0; $i < $formCount; $i++)
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <x-form-input-horizontal label="No. SN" name="nomor_serial_barang"
                                placeholder="Nomor Serial Number..."
                                value="{{ isset($row) ? $row->nomor_serial_barang ?? '' : '' }}" />
                        </div>
                        <div class="col-lg-6">
                            <x-form-select-horizontal label="Status" name="status_serial_barang" :data="$array_status_serial_barang"
                                value="{{ isset($row) ? $row->status_serial_barang ?? '' : 'ready' }}" />
                        </div>
                    </div>
                @endfor
            @endif
        </div>
        <div class="modal-footer">
            <div class="row justify-content-end">
                <div class="col-sm-12">
                    <x-button-cancel-modal />
                    <x-button-submit-modal />
                </div>
            </div>
        </div>
    </form>

</div>


<script src="{{ asset('js/master/serialBarang/form.js') }}"></script>
