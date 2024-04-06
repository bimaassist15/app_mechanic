@extends('layouts.app.index')

@section('title')
    Halaman Dashboard
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
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
