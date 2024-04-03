@extends('layouts.app.index')

@section('title')
    Detail Mekanik Garansi
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="areaPengembalianServis">
            @include('service::mekanikGaransi.partialsPengembalian.detailInfoAwal')

            @include('service::viewGroupService.partialsPengembalian.detailCustomer')

            @include('service::viewGroupService.partialsPengembalian.detailOrderServis')

            @include('service::viewGroupService.partialsPengembalian.detailOrderBarang')

            @include('service::viewGroupService.partialsPengembalian.detailHistori')

            @include('service::viewGroupService.partialsPengembalian.detailInformasiServis')
        </div>
    </div>
@endsection

@push('custom_js')
    @include('service::groupService.pengembalian')
    <script>
        runDataPengembalian();
    </script>
@endpush
