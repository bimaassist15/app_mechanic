@extends('layouts.app.index')

@section('title')
    Halaman My Profile
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div id="output_profile"></div>
        <div class="w-100 text-center loading-profile d-none">
            <div class="spinner-border" role="status">
                <span class="visually-hidden">Loading...</span>
            </div> <br />
            <strong>Loading...</strong>
        </div>
    </div>
@endsection

@push('custom_js')
    <script class="url_root" data-value="{{ url('/') }}"></script>
    <script src="{{ asset('js/myProfile/index.js') }}"></script>
@endpush
