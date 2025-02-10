<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, viewport-fit=cover, shrink-to-fit=no">
        <link href="{{ asset('vendor/fontawesome/css/fontawesome.min.css')}}" rel="stylesheet">
        <link href="{{ asset('vendor/fontawesome/css/solid.min.css')}}" rel="stylesheet">
        <link href="{{ asset('vendor/fontawesome/css/brands.min.css')}}" rel="stylesheet">
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
        <link href="{{ asset('css/master.css')}}" rel="stylesheet">
        <link href="{{ asset('vendor/flagiconcss/css/flag-icon.min.css')}}" rel="stylesheet">
        @stack('styles')
        <!-- Title -->
        <title>{{ $title ?? config('app.name') }}</title>

        @livewireStyles
    </head>
    <body>
        <div class="wrapper">
        <x-admin.sidebar/>
        <div id="body" class="active">
        <x-admin.navbar/>
        <div class="content">
            <div class="container">
        {{ $slot }}
    </div>
    </div>
</div>
</div>
    <script src="{{ asset('vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('vendor/chartsjs/Chart.min.js')}}"></script>
    <script src="{{ asset('js/dashboard-charts.js')}}"></script>
    <script src="{{ asset('js/script.js')}}"></script>
    @stack('scripts')
    @livewireScripts
    </body>

</html>
