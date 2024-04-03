@extends('layouts.app.index')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{ Breadcrumbs::render('backup') }}

        <!-- Basic Bootstrap Table -->
        <div class="card text-center">
            <h5 class="card-header">
                Data Backup
            </h5>
            <div class="card-body text-center">
                <i class="fa-solid fa-database fa-5x"></i>
            </div>
            <div class="card-footer">
                <x-button-main title="Simpan" icon='<i class="fa-regular fa-paper-plane"></i>'></x-button-main>
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->
    </div>

    @push('custom_js')
        <script class="url_datatable" data-url="{{ url('setting/backup') }}"></script>

        <script src="{{ asset('js/setting/backup/index.js') }}"></script>
    @endpush
@endsection
