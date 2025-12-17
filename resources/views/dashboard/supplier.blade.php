@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h1 class="fw-bold text-darkblue">
            <i class="bi bi-shop me-2"></i> TapEats Supplier Portal
        </h1>
        <p class="text-muted">Welcome back, {{ Auth::user()->name }}. Here is a snapshot of your operations.</p>
    </div>
</div>

<div class="row g-4">
    
    <!-- Quick Access Card: Manage Menu -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm h-100 border-start border-5 border-accent">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-card-list display-6 text-accent me-3"></i>
                    <div>
                        <h5 class="card-title fw-semibold text-darkblue">Manage Menu</h5>
                        <p class="card-text text-muted">Update prices, add new dishes, or mark items as unavailable.</p>
                    </div>
                </div>
                <a href="{{ url('/supplier/menu') }}" class="btn btn-sm btn-outline-darkblue mt-3">
                    Go to Menu <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Access Card: New Orders -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm h-100 border-start border-5 border-success">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-bell-fill display-6 text-success me-3"></i>
                    <div>
                        <h5 class="card-title fw-semibold text-darkblue">Pending Orders</h5>
                        <p class="card-text text-muted">Review new requests and confirm orders for preparation.</p>
                    </div>
                </div>
                <!-- Mock count for visualization -->
                <a href="{{ url('/supplier/orders') }}" class="btn btn-sm btn-outline-success mt-3">
                    View New (5) <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Access Card: Sales Reports -->
    <div class="col-md-6 col-lg-4">
        <div class="card shadow-sm h-100 border-start border-5 border-info">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <i class="bi bi-graph-up display-6 text-info me-3"></i>
                    <div>
                        <h5 class="card-title fw-semibold text-darkblue">Performance Reports</h5>
                        <p class="card-text text-muted">Track sales volume, revenue, and top-selling items.</p>
                    </div>
                </div>
                <a href="{{ url('/supplier/reports') }}" class="btn btn-sm btn-outline-info mt-3">
                    View Analytics <i class="bi bi-arrow-right"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Example Widget: Operational Status -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-darkblue text-white fw-semibold">
                <i class="bi bi-gear-wide-connected me-1"></i> Operational Status
            </div>
            <div class="card-body">
                <h6 class="text-success fw-bold"><i class="bi bi-circle-fill small me-2"></i> Currently Active</h6>
                <p>Your shop is live and accepting orders from customers in your designated delivery area.</p>
                <button class="btn btn-sm btn-outline-secondary">Go Offline</button>
            </div>
        </div>
    </div>

    <!-- Example Widget: Recent Activity -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-darkblue text-white fw-semibold">
                <i class="bi bi-clock-history me-1"></i> Recent Activity
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item">Order #987 confirmed for delivery. <span class="badge bg-secondary float-end">5 mins ago</span></li>
                <li class="list-group-item">Product 'Spicy Ramen' cost updated. <span class="badge bg-secondary float-end">1 hour ago</span></li>
                <li class="list-group-item">New order #988 placed. <span class="badge bg-success float-end">Just now</span></li>
            </ul>
        </div>
    </div>

</div>

@endsection