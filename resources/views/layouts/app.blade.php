<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bloombeads')</title>
    @vite('resources/css/app.css') {{-- if using Vite/Tailwind --}}
</head>
<body class="bg-gray-50 font-poppins">
    {{-- Header --}}
    <x-header />

    {{-- Page Content --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <x-footer />
</body>
</html>
