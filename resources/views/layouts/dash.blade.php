<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ $title }} | KUIN</title>
    <meta name="robots" content="noindex">
    <link href="{{ asset('vendor/simplebar.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.rtl.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor-material-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor-material-icons.rtl.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor-fontawesome-free.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor-fontawesome-free.rtl.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor-ion-rangeslider.css"') }} rel="stylesheet">
    <link href="{{ asset('css/vendor-ion-rangeslider.rtl.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendor-flatpickr.css" rel') }}="stylesheet">
    <link href="{{ asset('css/vendor-flatpickr.rtl.css"') }} rel="stylesheet">
    <link href="{{ asset('css/vendor-flatpickr-airbnb.css"') }} rel="stylesheet">
    <link href="{{ asset('css/vendor-flatpickr-airbnb.rtl.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/jqvmap/jqvmap.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap4.min.css">
    <link rel="icon" href="{{ asset('img/logo/icon.png') }}">
</head>

<body class="layout-default">

    <div class="preloader"></div>

    <div class="mdk-drawer-layout js-mdk-drawer-layout" data-push data-responsive-width="992px" data-fullbleed>
        <div class="mdk-drawer-layout__content">

            <!-- Header Layout -->
            <div class="mdk-header-layout js-mdk-header-layout" data-has-scrolling-region>

                <!-- Header Layout Content -->
                <div class="my-3" style="height: 100vh; overflow-y: auto">
                   
                <!-- Header -->
                @include('components.header')
                <!-- // END Header -->

                    @yield('dash-content')

                </div>
                <!-- // END header-layout__content -->

            </div>
            <!-- // END header-layout -->

        </div>
        <!-- // END drawer-layout__content -->

        @include('components.sidebar')
    </div>
    <!-- // END drawer-layout -->

    <div id="app-settings">
        <app-settings></app-settings>
    </div>

    @stack('script')

    <!-- jQuery -->
    <script src="{{ asset('vendor/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/popper.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/simplebar.min.js') }}"></script>
    <script src="{{ asset('vendor/dom-factory.js') }}"></script>
    <script src="{{ asset('vendor/material-design-kit.js') }}"></script>
    <script src="{{ asset('vendor/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ asset('js/ion-rangeslider.js') }}"></script>
    <script src="{{ asset('js/toggle-check-all.js') }}"></script>
    <script src="{{ asset('js/check-selected-row.js') }}"></script>
    <script src="{{ asset('js/dropdown.js') }}"></script>
    <script src="{{ asset('js/sidebar-mini.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/app-settings.js') }}"></script>
    <script src="{{ asset('vendor/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('js/flatpickr.js') }}"></script>
    <script src="{{ asset('js/settings.js') }}"></script>
    <script src="{{ asset('vendor/Chart.min.js') }}"></script>
    <script src="{{ asset('js/chartjs-rounded-bar.js') }}"></script>
    <script src="{{ asset('js/charts.js') }}"></script>
    <script src="{{ asset('vendor/jqvmap/jquery.vmap.min.js') }}"></script>
    <script src="{{ asset('vendor/jqvmap/maps/jquery.vmap.world.js') }}"></script>
    <script src="{{ asset('js/vector-maps.js') }}"></script>
    <script src="{{ asset('js/page.dashboard.js') }}"></script>

    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function () {
            $('#data').DataTable();
        });
    </script>
    @include('components.popup')
</body>

</html>