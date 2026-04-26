<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'BANGSA Blog') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>* { font-family: 'Inter', sans-serif; }</style>
</head>
<body class="bg-gray-50 antialiased">
    <div class="min-h-screen flex flex-col">
        <!-- Mini Header -->
        <div class="bg-white border-b border-gray-200">
            <div class="max-w-[1100px] mx-auto px-4 h-14 flex items-center">
                <a href="/" class="flex items-baseline">
                    <span style="font-size:22px; font-weight:900; color:#e53e3e; letter-spacing:-0.5px;">BANGSA</span>
                    <span style="font-size:22px; font-weight:900; color:#1a1a1a; letter-spacing:-0.5px;">BLOG</span>
                </a>
            </div>
        </div>

        <!-- Auth Container -->
        <div class="flex-1 flex items-center justify-center py-12 px-4">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
