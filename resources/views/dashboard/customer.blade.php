@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h1 class="fw-bold text-darkblue">
            <i class="bi bi-cup-hot-fill me-2"></i> TapEats Customer Dashboard
        </h1>
        <p class="text-muted">Welcome back, {{ Auth::user()->name }}. Ready to order your next meal?</p>
    </div>
</div>

<div class="row g-4 mb-5">
    
    <!-- Quick Action Card: Start New Order -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-5 border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-success fw-semibold">New Order</div>
                        <div class="h3 mb-0 fw-bold text-darkblue">Find Food Now</div>
                    </div>
                    <i class="bi bi-search display-5 text-success opacity-50"></i>
                </div>
                <a href="{{ url('/search') }}" class="small text-darkblue">Browse Suppliers &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Quick Action Card: Shopping Cart -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-5 border-accent">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-accent fw-semibold">Your Cart</div>
                        <!-- Mock data -->
                        <div class="h3 mb-0 fw-bold text-darkblue">3 Items</div>
                    </div>
                    <i class="bi bi-cart display-5 text-accent opacity-50"></i>
                </div>
                <a href="{{ url('/cart') }}" class="small text-darkblue">Review & Checkout &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Quick Action Card: Last Order Reorder -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-5 border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-info fw-semibold">Reorder Quickly</div>
                        <div class="h3 mb-0 fw-bold text-darkblue">Spicy Ramen</div>
                    </div>
                    <i class="bi bi-arrow-clockwise display-5 text-info opacity-50"></i>
                </div>
                <a href="{{ url('/orders/last/reorder') }}" class="small text-darkblue">Order Again &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Quick Action Card: Account Settings -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-5 border-secondary">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-secondary fw-semibold">My Profile</div>
                        <div class="h3 mb-0 fw-bold text-darkblue">Update Info</div>
                    </div>
                    <i class="bi bi-person-circle display-5 text-secondary opacity-50"></i>
                </div>
                <a href="{{ url('/profile/settings') }}" class="small text-darkblue">Go to Settings &rarr;</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    
    <!-- Widget: Recent Orders -->
    <div class="col-lg-7">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-darkblue text-white fw-semibold">
                <i class="bi bi-basket me-1"></i> Recent Order Activity
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="fw-semibold">Order #988 (The Cozy Bakery)</div>
                    <span class="badge bg-success rounded-pill">Delivered</span>
                    <a href="{{ url('/orders/988') }}" class="small text-darkblue">View Details</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="fw-semibold">Order #987 (Fresh Catch Sushi)</div>
                    <span class="badge bg-warning text-dark">In Transit</span>
                    <a href="{{ url('/orders/987') }}" class="small text-darkblue">Track &rarr;</a>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <div class="fw-semibold">Order #986 (Green Garden Salads)</div>
                    <span class="badge bg-secondary">Cancelled</span>
                    <a href="{{ url('/orders/986') }}" class="small text-darkblue">View Details</a>
                </li>
            </ul>
            <div class="card-footer text-center">
                <a href="{{ url('/orders/my') }}" class="small fw-semibold text-darkblue">View All Order History</a>
            </div>
        </div>
    </div>

    <!-- Widget: Favorite Suppliers -->
    <div class="col-lg-5">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-darkblue text-white fw-semibold">
                <i class="bi bi-heart-fill me-1"></i> Your Favorite Suppliers
            </div>
            <div class="card-body">
                <div class="list-group">
                    <a href="{{ url('/supplier/bakery') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        The Cozy Bakery <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ url('/supplier/sushi') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Fresh Catch Sushi <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ url('/supplier/pizza') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        Mama Mia Pizza <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ url('/supplier/coffee') }}" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                        The Daily Grind Coffee <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection