<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>VCC Cam System</title>
    <link rel="icon" href="{{ asset('logo_vcc.png') }}">

    <!-- Scripts -->
    <!-- <script src="{{ asset('js/app.js') }}" defer></script> -->
    <script type="text/javascript">
        var csrfToken = "{{ csrf_token() }}"    ;
    </script>

    <script src="{{ asset('js/Metodos.js') }}" ></script>
    <script src="{{ asset('js/Avaria.js') }}" ></script>
    <script src="{{ asset('js/jquery/jquery-3.3.1.slim.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/Xhttp.js') }}"></script>

    <script src="{{ asset('js/jquery/jquery-3.4.1.js') }}"></script>
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link href="{{ asset('css/w3.css') }}" rel="stylesheet">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fontawesome/css/all.css') }}" rel="stylesheet">

</head>