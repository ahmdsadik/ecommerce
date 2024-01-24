<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
<script src="{{ asset('assets/dashboard/vendor/libs/jquery/jquery.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendor/libs/popper/popper.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendor/js/bootstrap.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendor/libs/hammer/hammer.js') }}"></script>
<script src="{{ asset('assets/dashboard/vendor/libs/typeahead-js/typeahead.js') }}"></script>


<script src="{{ asset('assets/dashboard/vendor/js/menu.js') }}"></script>
<!-- endbuild -->

<!-- Vendors JS -->
<script src="{{ asset('assets/dashboard/vendor/libs/apex-charts/apexcharts.js') }}"></script>

<!-- Main JS -->
<script src="{{ asset('assets/dashboard/js/main.js') }}"></script>

<!-- Page JS -->
<script src="{{ asset('assets/dashboard/js/dashboards-analytics.js') }}"></script>



<script>
    const user_id = '{{ auth('admin')->id() }}';
    const user_name = '{{ auth('admin')->user()->name }}';
    const csrf_token = '{{ csrf_token() }}';
</script>