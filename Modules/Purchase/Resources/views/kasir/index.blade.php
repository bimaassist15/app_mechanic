@extends('layouts.app.index')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('barang') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="mb-3 border-bottom border-dark pb-3">
                    <x-button-main title="Cash" icon='<i class="fa-solid fa-money-bill"></i>' />
                    <x-button-main title="Piutang" icon='<i class="fa-solid fa-money-bill-1-wave"></i>' />
                </div>
                <div class="d-flex flex-wrap justify-content-between">
                    <div>
                        <strong>No. Invoice: 328923823</strong>
                    </div>
                    <div class="d-flex flex-wrap">
                        <div class="me-2">
                            @php
                                $data = [['id' => '', 'label' => 'Belum Ada']];
                            @endphp
                            <select name="kode_barang" class="form-select" id="kode_barang">
                                <option selected>-- Pilih Barang --</option>
                                @foreach ($data as $index => $item)
                                    @php
                                        $item = (object) $item;
                                    @endphp
                                    <option value="{{ $item->id }}">{{ $item->label }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-button-main icon='<i class="fa-solid fa-magnifying-glass"></i>'></x-button-main>
                        </div>
                    </div>
                </div>
            </h5>
            <div class="table-responsive text-nowrap px-3">
                <table class="table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Qty</th>
                            <th>No. SN</th>
                            <th>Sub Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ route('kasir.index') }}"></script>
        <script src="{{ asset('js/purchase/kasir/index.js') }}"></script>
    @endpush
@endsection
