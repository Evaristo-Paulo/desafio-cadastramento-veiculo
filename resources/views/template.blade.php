<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @stack('css')
    <link href="{{ asset('icon-font/lineicons.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <link rel="stylesheet" href="{{ url('responsive.css') }}">
    <title>eTips (4)</title>
</head>

<body>
    <div class="wrapper">
        @include('sweetalert::alert')
        @include('partials/header')
        @include('partials.banner')

        @yield('content')
        <!-- END CONTENT-->
        @include('partials.footer')
        <!-- END FOOTER-->
    </div>
    @include('partials.modal')
    @yield('filter')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('script.js') }}"></script>
    @stack('js')
</body>

</html>
