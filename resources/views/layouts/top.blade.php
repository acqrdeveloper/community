<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta http-equiv="Expires" content="0">
<meta http-equiv="Last-Modified" content="0">
<meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
<meta http-equiv="Pragma" content="no-cache">
<meta name="csrf_token" content="{{ csrf_token() }}">

@if(env('APP_ENV') == 'local')
    <link rel="stylesheet" href="{{ asset('node_modules/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('node_modules/vue-multiselect/dist/vue-multiselect.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@else
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}">
@endif