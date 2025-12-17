<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TapEats | Dashboard</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons (Used for the Sidebar and Cards) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<link rel="icon" href="{{ asset('images/logo/EJO SOLUTION - LOGO - ONLY.png') }}" type="image/png">
    <style>
        /* Custom Dark Blue Theme Styling */
        :root {
            --bs-darkblue: #001f3f; /* Deep Navy Blue */
            --bs-accent: #FFA726;   /* Vibrant Orange/Gold */
        }
        .bg-darkblue { background-color: var(--bs-darkblue) !important; }
        .text-darkblue { color: var(--bs-darkblue) !important; }
        .btn-accent { background-color: var(--bs-accent); border-color: var(--bs-accent); color: var(--bs-darkblue); }
        .btn-accent:hover { background-color: #e09400; border-color: #e09400; color: #fff; }

        /* Sidebar Specific Styles */
        #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem; /* Hidden by default */
            transition: margin .25s ease-out;
            background-color: var(--bs-darkblue);
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
        }

        #sidebar-wrapper .list-group-item {
            color: rgba(255, 255, 255, .8);
            background-color: transparent;
            border: none;
            padding: 1rem 1.5rem;
        }
        #sidebar-wrapper .list-group-item:hover {
            color: #fff;
            background-color: rgba(255, 255, 255, .1);
        }
        #sidebar-wrapper .list-group-item.active {
            color: var(--bs-accent);
            background-color: rgba(255, 255, 255, .15);
            border-left: 5px solid var(--bs-accent);
        }

        #page-content-wrapper {
            width: 100%;
        }

        /* Toggle State */
        .toggled #sidebar-wrapper {
            margin-left: 0; /* Show on toggle */
        }
        
        /* Mobile adjustment to keep content visible when sidebar is open */
        @media (min-width: 992px) {
            #sidebar-wrapper {
                margin-left: 0; /* Always visible on desktop */
            }
            .toggled #sidebar-wrapper {
                margin-left: -15rem; /* Hide on toggle for desktop */
            }
            #page-content-wrapper {
                min-width: 0;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        @include('layouts.partials.asidebar')

        <!-- Page Content Wrapper -->
        <div id="page-content-wrapper">
            
            <!-- Header (Top Nav) -->
            @include('layouts.partials.header')

            <!-- Main Content Section -->
            <div class="container-fluid py-4">
                @yield('content')
            </div>

            <!-- Footer -->
            @include('layouts.partials.footer')

        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar Toggle Script
        const sidebarToggle = document.getElementById('sidebarToggle');
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', function(e) {
                e.preventDefault();
                document.getElementById('wrapper').classList.toggle('toggled');
            });
        }
    </script>
</body>
</html>