<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" class="light-style  customizer-hide"
      dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}" data-theme="theme-semi-dark"
      data-assets-path="{{ asset('assets/dashboard/') }}/" data-template="vertical-menu-template-semi-dark">


<!-- auth-login-basic.html , Sat, 26 Mar 2022 16:51:58 GMT -->
<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

    <title>@yield('title')</title>

    <meta name="description"
          content="Most Powerful &amp; Comprehensive Bootstrap 5 HTML Admin Dashboard Template built for developers!"/>
{{--    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">--}}
    <meta name="keywords" content="dashboard, bootstrap 5 dashboard, bootstrap 5 design, bootstrap 5">
    <!-- Canonical SEO -->
    <link rel="canonical" href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon"
          href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/favicon/favicon.ico"/>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;500;600;700;800;900;1000&display=swap" rel="stylesheet">


    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/fonts/boxicons.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/fonts/fontawesome.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/fonts/flag-icons.css') }}"/>

    <!-- Core CSS -->
    <link rel="stylesheet"
          href="{{ asset('assets/dashboard/vendor/css/rtl/core-dark.css') }}" class="template-customizer-core-css"/>
    <link rel="stylesheet"
          href="{{ asset('assets/dashboard/vendor/css/rtl/theme-default-dark.css') }}"
          class="template-customizer-theme-css"/>
    <link rel="stylesheet" href="{{ asset('assets/dashboard/css/demo.css') }}"/>

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/libs/typeahead-js/typeahead.css') }}"/>
    <!-- Vendor -->
    <link rel="stylesheet"
          href="{{ asset('assets/dashboard/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}"/>

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/dashboard/vendor/css/pages/page-auth.css') }}">
    <!-- Helpers -->
    <script src="{{ asset('assets/dashboard/vendor/js/helpers.js')}}"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Template customizer: To hide customizer set displayCustomizer value false in config.js.  -->
    <script src="{{ asset('assets/dashboard/vendor/js/template-customizer.js') }}"></script>
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/dashboard/js/config.js') }}"></script>

    <style>
        body{
            font-family: "Cairo", serif;
        }
    </style>

</head>

<body>

<!-- Content -->

@yield('content')

<!-- / Content -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets/dashboard/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{ asset('assets/dashboard/vendor/libs/popper/popper.js')}}"></script>
<script src="{{ asset('assets/dashboard/vendor/js/bootstrap.js')}}"></script>
{{--<script src="{{ asset('assets/dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>--}}

{{--<script src="{{ asset('assets/dashboard/vendor/libs/hammer/hammer.js')}}"></script>--}}
{{--<script src="{{ asset('assets/dashboard/vendor/libs/i18n/i18n.js')}}"></script>--}}
{{--<script src="{{ asset('assets/dashboard/vendor/libs/typeahead-js/typeahead.js')}}"></script>--}}

<script src="{{ asset('assets/dashboard/vendor/js/menu.js')}}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
{{--<script src="{{ asset('assets/dashboard/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>--}}
{{--<script src="{{ asset('assets/dashboard/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>--}}
{{--<script src="{{ asset('assets/dashboard/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>--}}

<!-- Main JS -->
<script src="{{ asset('assets/dashboard/js/main.js')}}"></script>

<!-- Page JS -->
<script src="{{ asset('assets/dashboard/js/pages-auth.js')}}"></script>

</body>


<!-- auth-login-basic.html , Sat, 26 Mar 2022 16:52:00 GMT -->
</html>
