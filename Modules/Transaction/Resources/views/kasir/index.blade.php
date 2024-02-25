@extends('layouts.app.index')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('kasirTransaction') }}

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
                            <th>Sub Total</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                    </tbody>
                </table>
            </div>
            <div class="px-3 mt-5 mb-5">
                <div class="row">
                    <div class="col-lg-6">
                        @php
                            $data = [['id' => '', 'label' => 'Belum Ada']];
                        @endphp
                        <x-form-select-vertical label="Supplier" name="supplier_id" :data="$data" />
                    </div>
                    <div class="col-lg-6">
                        <table class="w-100">
                            <tr>
                                <td>Total</td>
                                <td style="padding: 20px 5px 5px 5px;">Rp.</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td>Bayar</td>
                                <td style="padding: 20px 5px 5px 5px;">Rp.</td>
                                <td>
                                    <input type="text" class="form-control" name="bayar" placeholder="Bayar Rp." />
                                </td>
                            </tr>
                            <tr>
                                <td>Kembalian</td>
                                <td style="padding: 20px 5px 5px 5px;">Rp.</td>
                                <td>0</td>
                            </tr>
                            <tr>
                                <td colspan="2"></td>
                                <td><x-button-main title="Simpan Payment"
                                        icon='<i class="fa-solid fa-cash-register"></i>' /></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ route('kasir.index') }}"></script>
        <script src="{{ asset('js/transaction/kasir/index.js') }}"></script>
    @endpush
@endsection
