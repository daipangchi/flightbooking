@section('common-scripts')
    <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.daterangepicker.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.countTo.js') }}"></script>
    <script src="{{ asset('assets/js/json2.min.js') }}"></script>
    <script src="{{ asset('assets/js/jquery.html5-placeholder-shim.min.js') }}"></script>
    <script src="{{ asset('assets/js/cookie.min.js') }}"></script>

    <script src="{{ asset('assets/js/optin.js') }}?v=1.2"></script>
    <script src="{{ asset('assets/js/functions.js') }}"></script>
    <script src="{{ asset('assets/js/js.js') }}"></script>
@show

@yield('custom-scripts')