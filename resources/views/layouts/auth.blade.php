<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
        <meta name="description" content="Suha - Multipurpose E-commerce Mobile HTML Template">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="theme-color" content="#625AFA">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-status-bar-style" content="black">
        <!-- The above tags *must* come first in the head, any other head content must come *after* these tags -->
        <!-- Title -->
        <title>{{ $title ?? config('app.name') }}</title>
        <link rel="preconnect" href="https://fonts.googleapis.com/">
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,200..800;1,200..800&amp;display=swap" rel="stylesheet">
        <!-- Favicon -->
        {{-- <link rel="icon" href="img/icons/icon-72x72.png"> --}}
        <!-- Apple Touch Icon -->
        {{-- <link rel="apple-touch-icon" href="img/icons/icon-96x96.png">
        <link rel="apple-touch-icon" sizes="152x152" href="img/icons/icon-152x152.png">
        <link rel="apple-touch-icon" sizes="167x167" href="img/icons/icon-167x167.png">
        <link rel="apple-touch-icon" sizes="180x180" href="img/icons/icon-180x180.png"> --}}
        <!-- CSS Libraries -->
        <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/tabler-icons.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/animate.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/magnific-popup.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/css/nice-select.css')}}">
        <!-- Stylesheet -->
        <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    </head>
    <body>
        @yield('content')
        <script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{asset('assets/js/jquery.min.js')}}"></script>
        <script src="{{asset('assets/js/otp-timer.js')}}"></script>
    </body>

</html>
