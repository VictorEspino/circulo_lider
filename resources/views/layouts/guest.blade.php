<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ mix('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ mix('js/app.js') }}" defer></script>

        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&display=swap" rel="stylesheet">
        <style>
            .body-bg {
                background-color: #000000;
                background-image: linear-gradient(315deg, #404040 0%, #000000 74%);
             }
        </style>
    </head>
    <body class="body-bg min-h-screen pt-8 md:pt-8 pb-6 px-2 md:px-0" style="font-family:'Lato',sans-serif;">
        <header class="max-w-lg mx-auto">
            <h1 class="text-xl font-bold text-white text-center">Circulo Lider</h1><br />
            <center>
                <image src="{{url('images/circulo_lider.png') }}" class="w-48 rounded-full shadow-2xl"></image>
            </center>            
        </header>

            {{ $slot }}

    </body>
</html>
