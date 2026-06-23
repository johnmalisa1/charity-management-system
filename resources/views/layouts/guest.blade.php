<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

<!-- Background wrapper -->
<div class="min-h-screen flex items-center justify-center relative"
     style="background-image: url('/images/charity-bg.jpg'); 
            background-size: cover; 
            background-position: center; 
            background-repeat: no-repeat;">



        <!-- Dark overlay -->
        <div class="absolute inset-0 bg-black bg-opacity-60"></div>

        <!-- Card -->
<div class="relative z-10 max-w-md px-8 py-10 
            rounded-2xl shadow-xl 
            bg-white/20 dark:bg-gray-900/30 
            backdrop-blur-lg border border-white/30 overflow-hidden">
    @yield('content')
</div>

    </div>
</body>
</html>







