<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    {{-- CSRF Token for AJAX/Fetch Requests --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    {{-- Bootstrap CSS (Assuming you use this) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    {{-- Custom Stylesheet --}}
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    
    {{-- Dynamic Title / Head Content --}}
    @yield('head') 
</head>
<body class="position-relative">

    {{-- 1. HEADER (Navigation Bar) --}}
    @include('layouts.partials.header')

    {{-- Main Content Area --}}
    <main class="container-fluid">
        {{-- The content from child views (e.g., menu.index) will be injected here --}}
        @yield('content')
    </main>

    {{-- 2. ASIDE (Cart/Sidebar View) --}}
    @include('layouts.partials.aside')

    {{-- 3. FOOTER --}}
    @include('layouts.partials.footer')


    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    {{-- Global/Shared JavaScript --}}
    <script src="{{ asset('js/app.js') }}"></script> 
    
    {{-- Page Specific JavaScript (e.g., custom scripts for cart functions) --}}
    @yield('scripts')
</body>
</html>