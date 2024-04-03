@extends('layouts.app.index')

@section('title')
    Detail Kendaraan Servis
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="areaPenerimaanServis">
            @include('service::kendaraanServis.partialsPenerimaan.detailInfoAwal')

            @include('service::viewGroupService.partialsPenerimaan.detailCustomer')

            @include('service::viewGroupService.partialsPenerimaan.detailOrderServis')

            @include('service::viewGroupService.partialsPenerimaan.detailOrderBarang')

            @include('service::viewGroupService.partialsPenerimaan.detailHistori')

            @include('service::viewGroupService.partialsPenerimaan.detailInformasiServis')
        </div>

        <div class="areaPengembalianServis">
            @include('service::kendaraanServis.partialsPengembalian.detailInfoAwal')

            @include('service::viewGroupService.partialsPengembalian.detailCustomer')

            @include('service::viewGroupService.partialsPengembalian.detailOrderServis')

            @include('service::viewGroupService.partialsPengembalian.detailOrderBarang')

            @include('service::viewGroupService.partialsPengembalian.detailHistori')

            @include('service::viewGroupService.partialsPengembalian.detailInformasiServis')
        </div>
    </div>
@endsection

@push('custom_js')
    @include('service::groupService.globalRefresh')

    @include('service::groupService.penerimaan')

    @include('service::groupService.pengembalian')

    @include('service::groupService.actionRefresh')
@endpush
