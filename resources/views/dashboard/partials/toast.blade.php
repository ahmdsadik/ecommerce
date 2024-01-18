<!-- Toast with Animation -->
<div class="bs-toast toast toast-ex animate__animated my-2" role="alert" aria-live="assertive"
     aria-atomic="true" data-bs-delay="2000">
    <div class="toast-header">
        {{--        <i class='bx bx-bell me-2'></i>--}}
        {{--        <div class="me-auto fw-semibold">Bootstrap</div>--}}
        {{--        <small>11 mins ago</small>--}}
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        <i class='bx bx-bell me-2'></i>
        {{ session('msg') }}
    </div>
</div>
<!--/ Toast with Animation -->
