<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>app | Sign In</title>

    <!-- Bootstrap core Vue and Bootstrap-sass-->
    {{--<link rel="stylesheet" href="{{ asset('css/app.css') }}">--}}
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Core Styles-->
    <link rel="stylesheet" href="{{ asset('node_modules/metisMenu/dist/metisMenu.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sb-admin-2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/font-awesome/css/font-awesome.min.css') }}">
    <style>
        button, a {
            outline: 0 !important;
        }

        input {
            box-shadow: none !important;
        }

        body {
            background-color: #fff;
        }
    </style>
</head>

<body>


@yield('content')

<!-- Jquery-->
<script src="{{ asset('node_modules/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap core Vue and Bootstrap-sass-->
<script src="{{ asset('node_modules/bootstrap/dist/js/bootstrap.min.js') }}"></script>
{{--<script src="{{ asset('js/app.js') }}"></script>--}}
<!-- Core Scripts-->
<script src="{{ asset('node_modules/metisMenu/dist/metisMenu.min.js') }}"></script>
<script src="{{ asset('js/sb-admin-2.js') }}"></script>

</body>
</html>