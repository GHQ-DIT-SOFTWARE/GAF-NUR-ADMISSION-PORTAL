<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>PORTAL | {{ config('app.name') }}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="" />
    <meta name="keywords" content="">

    <meta name="author" content="Phoenixcoded" />
    <link rel="icon" href="{{ asset('logo-icon.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/flipclock.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
        integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
        crossorigin="anonymous" />
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css"
        integrity="sha512-CbQfNVBSMAYmnzP3IC+mZZmYMP2HUnVkV4+PwuhpiMUmITtSpS7Prr3fNncV1RBOnWxzz4pYQ5EAGG4ck46Oig=="
        crossorigin="anonymous" rel="stylesheet" />
</head>
<div class="content-wrapper">
    @yield('content')
</div>
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="{{ asset('frontend/assets/js/vendor-all.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/bootstrap.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/ripple.js') }}"></script>
<script src="{{ asset('frontend/assets/js/pcoded.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/moment.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery-ui.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
    integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
    crossorigin="anonymous"></script>
<script src="{{ asset('frontend/assets/js/plugins/sweetalert.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/pages/ac-alert.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/select2.full.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/pages/form-select-custom.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/jquery.bootstrap.wizard.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/prism.js') }}"></script> --}}
</body>

</html>
