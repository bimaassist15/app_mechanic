@extends('layouts.app.index')

@section('title')
    Halaman Dashboard
@endsection

@php
    $myCabang = UtilsHelp::myCabang();
@endphp
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5>Dashboard {{ $myCabang->nama_cabang }} - {{ $myCabang->alamat_cabang }}</h5>
        @include('dashboard::partials.invoice')
        @include('dashboard::partials.infoItem')
        @include('dashboard::partials.doing')
        @include('dashboard::partials.reviewItem')
        @include('dashboard::partials.piutang')
        @include('dashboard::partials.statusServis')
    </div>
@endsection

@push('custom_js')
    <script class="url_root" data-value="{{ url('/') }}"></script>
    <script src="{{ asset('js/dashboard/index.js') }}"></script>
@endpush
