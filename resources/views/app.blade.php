<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        @inertiaHead
        @vite('resources/css/app.css')
        @vite('resources/js/app.js')
    </head>
    <body class="min-h-screen bg-blue-50 font-sans antialiased">
        @inertia
    </body>
</html>
