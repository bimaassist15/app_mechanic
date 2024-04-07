<!DOCTYPE html>

<html lang="en" class="light-style layout-menu-fixed layout-compact" dir="ltr" data-theme="theme-default"
    data-assets-path="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/"
    data-template="vertical-menu-template-free">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
        href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/img/favicon/favicon.ico" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    <link rel="stylesheet"
        href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet"
        href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/css/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet"
        href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/css/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet"
        href="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->

    {{-- other --}}
    <link rel="stylesheet" href="{{ asset('library/datatables/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables/DataTables-2.0.0/css/dataTables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('library/fontawesome-free-6.5.1-web/css/all.css') }}">
    <link rel="stylesheet" href="{{ asset('library/select2-develop/dist/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/select2-bootstrap-5-theme-1.3.0/select2-bootstrap-5-theme.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/sweetalert2/dist/sweetalert2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('library/bootstrap-datepicker-master/dist/css/bootstrap-datepicker.min.css') }}">
    @stack('custom_css')

    <!-- Helpers -->
    <script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/js/helpers.js"></script>
    <script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/js/config.js"></script>

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('partials.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('partials.navbar')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('partials.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->
    <x-modal-main title="Judul Modal" id="smallModal" size="modal-sm"></x-modal-main>
    <x-modal-main title="Judul Modal" id="mediumModal" size="modal-md"></x-modal-main>
    <x-modal-main title="Judul Modal" id="largeModal" size="modal-lg"></x-modal-main>
    <x-modal-main title="Judul Modal" id="extraLargeModal" size="modal-xl"></x-modal-main>
    <x-toast title="title" description="description" />


    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/libs/jquery/jquery.js">
    </script>
    <script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/libs/popper/popper.js">
    </script>
    <script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/js/bootstrap.js"></script>
    <script
        src="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js">
    </script>
    <script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/vendor/js/menu.js"></script>
    <script src="{{ asset('library/datatables/datatables.js') }}"></script>
    <script src="{{ asset('library/datatables/DataTables-2.0.0/js/dataTables.bootstrap5.js') }}"></script>

    <!-- endbuild -->

    <!-- Vendors JS -->

    <!-- Main JS -->
    <script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free') }}/assets/js/main.js"></script>

    <!-- Page JS -->

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <script src="{{ asset('library/select2-develop/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free/assets/js/ui-toasts.js') }}"></script>
    <script src="{{ asset('backend/sneat-bootstrap-html-admin-template-free/assets/js/ui-popover.js') }}"></script>

    <script src="{{ asset('js/utils/index.js') }}"></script>
    <script src="{{ asset('js/modal/index.js') }}"></script>
    <script src="{{ asset('library/sweetalert2/dist/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('library/autonumeric/dist/autoNumeric.min.js') }}"></script>
    <script src="{{ asset('library/jQuery-Plugin-To-Print-Any-Part-Of-Your-Page-Print/dist/jQuery.print.min.js') }}">
    </script>
    <script src="{{ asset('library/bootstrap-datepicker-master/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-change-cabang').on('click', function() {
                showModal({
                    url: $(this).data("urlcreate"),
                    modalId: $(this).data("typemodal"),
                    title: "Form Ganti Cabang",
                    type: "get",
                });
            });
        });
    </script>
    @stack('custom_js')
</body>

</html>
