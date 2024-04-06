@extends('layouts.app.index')

@section('title')
    Halaman My Profile
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

    </div>
@endsection

@push('custom_js')
    <script class="url_root" data-value="{{ url('/') }}"></script>
@endpush
