<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="{{ config('app.meta.description') }}" name="description" />
    <meta content="{{ config('app.meta.author') }}" name="author" />
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <meta name="theme-color" content="#2196f3" media="(prefers-color-scheme: light)">
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <meta name="init-url" content="{{ Auth::check() ? route('dashboard') : route('auth') }}" />
    <meta name="auth-url" content="{{ route('auth') }}" />
    <meta name="dashboard-url" content="{{ route('dashboard.show') }}" />

    <title>{{ config('app.name') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;500;800;900&display=swap"
        rel="stylesheet">

    <link href="{{ asset('css/materia.css' . '?v=' . Str::random(8)) }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/toastr/toastr.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('libs/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link href="{{ asset('css/app.css' . '?v=' . Str::random(8)) }}" rel="stylesheet" type="text/css" />

    <script type="text/javascript">
        var BASE_URL = "{{ url('/') }}";
    </script>
</head>

<body>
    <div id="app"></div>

    <script src="{{ asset('libs/jquery/jquery.min.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script>
    <script src="{{ asset('libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('libs/nprogress/nprogress.js') }}"></script>
    <script src="{{ asset('libs/metismenu/metisMenu.min.js') }}"></script>
    <script src="{{ asset('libs/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('libs/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('libs/select2/js/select2.min.js') }}"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>

    <script src="{{ asset('libs/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('libs/chart.js/Chart.bundle.min.js') }}"></script>

    {{-- <script src="https://cdn.datatables.net/plug-ins/1.10.19/sorting/datetime-moment.js"></script>
    <script src="https://cdn.datatables.net/plug-ins/1.10.19/dataRender/datetime.js" charset="utf8"></script> --}}

    <script src="{{ asset('libs/inputmask/min/jquery.inputmask.bundle.min.js') }}"></script>

    <script src="{{ asset('js/app.js' . '?v=' . Str::random(8)) }}"></script>
</body>

</html>
