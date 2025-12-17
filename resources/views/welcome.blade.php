<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    
    <title>TapEats | Connect & Order</title>

    <style>
        /* Custom CSS to enforce the Dark Blue theme */
        .bg-darkblue {
            background-color: #001f3f !important; /* Deep Navy Blue */
        }
        .text-darkblue {
            color: #001f3f !important;
        }
        .btn-accent {
            background-color: #FFA726; /* Vibrant Orange/Gold */
            border-color: #FFA726;
            color: #001f3f; /* Dark text on light button */
        }
        .btn-accent:hover {
            background-color: #e09400;
            border-color: #e09400;
            color: #fff;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-darkblue fixed-top shadow-lg">
        <div class="container">
            <a class="navbar-brand fw-bold fs-4" href="#">TapEats</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="#">Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#services">Services</a></li>
                    <li class="nav-item"><a class="nav-link" href="#users">Users</a></li>
                    <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-accent ms-lg-3">Login / Register</a>
            </div>
        </div>
    </nav>
    
    <main data-bs-spy="scroll" data-bs-target="#navbarNav" data-bs-root-margin="0px 0px -40%" data-bs-smooth-scroll="true" class="scrollspy-example bg-body-tertiary" tabindex="0">
        
        <section class="bg-darkblue text-white d-flex align-items-center" style="min-height: 100vh; padding-top: 56px;">
            <div class="container py-5">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <h1 class="display-3 fw-bold mb-3">Your Next Meal, Delivered.</h1>
                        <p class="lead mb-4">
                            Connecting <b>Food Suppliers </b>directly to <b>Customers</b> with a seamless, multi-user management platform. Browse menus, compare costs, and place your order today!
                        </p>
                        <a href="#" class="btn btn-accent btn-lg me-3 shadow-sm">Start Ordering Now!</a>
                        <a href="#" class="btn btn-outline-light btn-lg shadow-sm">Become a Supplier</a>
                    </div>
                    <div class="col-lg-6 text-center">
                         
                    </div>
                </div>
            </div>
        </section>

        <hr>

        <section id="services" class="py-5 bg-light">
            <div class="container">
                <h2 class="text-center fw-bold mb-5 text-darkblue">What We Offer</h2>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="card h-100 p-3 shadow-sm border-0">
                            <div class="card-body text-center">
                                <i class="bi bi-shop fs-1 text-accent"></i> <h4 class="card-title mt-3 fw-semibold">Supplier Menu Management</h4>
                                <p class="card-text">Suppliers can easily upload, update, and manage their daily/weekly menus, pricing, and availability in real-time.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 p-3 shadow-sm border-0">
                            <div class="card-body text-center">
                                <i class="bi bi-search fs-1 text-accent"></i> <h4 class="card-title mt-3 fw-semibold">Intuitive Search & Ordering</h4>
                                <p class="card-text">Customers can search for food based on location, type, and cost, then place and track orders instantly.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card h-100 p-3 shadow-sm border-0">
                            <div class="card-body text-center">
                                <i class="bi bi-people fs-1 text-accent"></i> <h4 class="card-title mt-3 fw-semibold">Complete Delivery & Admin Tools</h4>
                                <p class="card-text">Dedicated portals for Delivery personnel, Admins, and Super Admins to manage logistics and system health.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <hr>

        <section id="users" class="py-5 bg-white">
            <div class="container">
                <h2 class="text-center fw-bold mb-5 text-darkblue">User Roles in the System</h2>
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-6 g-4 text-center">
                    
                    <div class="col">
                        <div class="p-3 border rounded h-100 bg-light">
                            <i class="bi bi-gear-fill fs-3 text-darkblue"></i>
                            <p class="fw-bold mb-0 mt-2">Super Admin</p>
                            <small class="text-muted">System Master</small>
                        </div>
                    </div>

                    <div class="col">
                        <div class="p-3 border rounded h-100 bg-light">
                            <i class="bi bi-shield-fill-check fs-3 text-darkblue"></i>
                            <p class="fw-bold mb-0 mt-2">Admin</p>
                            <small class="text-muted">Region/Group Manager</small>
                        </div>
                    </div>
                    
                    <div class="col">
                        <div class="p-3 border rounded h-100 bg-light">
                            <i class="bi bi-box-seam fs-3 text-darkblue"></i>
                            <p class="fw-bold mb-0 mt-2">Supplier</p>
                            <small class="text-muted">Menu & Order Manager</small>
                        </div>
                    </div>

                    <div class="col">
                        <div class="p-3 border rounded h-100 bg-light">
                            <i class="bi bi-person-circle fs-3 text-darkblue"></i>
                            <p class="fw-bold mb-0 mt-2">Customer</p>
                            <small class="text-muted">Order Placer</small>
                        </div>
                    </div>

                    <div class="col">
                        <div class="p-3 border rounded h-100 bg-light">
                            <i class="bi bi-bicycle fs-3 text-darkblue"></i>
                            <p class="fw-bold mb-0 mt-2">Delivery</p>
                            <small class="text-muted">Logistics & Drop-off</small>
                        </div>
                    </div>

                    <div class="col">
                        <div class="p-3 border rounded h-100 bg-light">
                            <i class="bi bi-people-fill fs-3 text-darkblue"></i>
                            <p class="fw-bold mb-0 mt-2">Normal User</p>
                            <small class="text-muted">Guest/Viewer</small>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <hr>

    </main>
    
    <footer class="bg-darkblue text-white py-4">
        <div class="container text-center">
            <p class="mb-0">&copy; 2025 FoodLink System. All rights reserved.</p>
            <small class="text-muted">Privacy Policy | Terms of Service</small>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr-net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</body>
</html>