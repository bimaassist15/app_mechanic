@extends('layouts.app.index')

@section('title')
    Halaman Generate Barang
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('generateBarang') }}

        <!-- Basic Bootstrap Table -->
        <div class="card">
            <h5 class="card-header">
                <div class="d-flex flex-wrap justify-content-between align-items-center">
                    <div>
                        Data Stok <strong class="text-primary">
                            {{ $barang->nama_barang }} = {{ $barang->stok_barang }}
                            Stok
                        </strong>
                    </div>
                    <div>
                        <a target="_blank" href="{{ url('master/generateBarcode/print?barang_id=' . $barang->id) }}"
                            class="btn btn-dark btn-print">
                            <i class="fa-solid fa-print"></i> &nbsp; Print
                        </a>
                    </div>
                </div>
            </h5>
            <div class="card-body" id="section-print">
                <div class="row">
                    @foreach ($serialBarang as $item)
                        <div class="col-lg-3 mb-2 d-flex justify-content-center">
                            <div class="d-flex flex-column">
                                {!! '<img src="data:image/png;base64,' .
                                    DNS1D::getBarcodePNG($item->nomor_serial_barang, 'C39+') .
                                    '" alt="barcode" width="180px;" height="80px;" />' !!}
                                <h6 class="text-center">{{ $item->nomor_serial_barang }}</h6>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>
@endsection

@push('custom_js')
    <script src="{{ asset('js/master/generateBarang/index.js') }}"></script>
@endpush
