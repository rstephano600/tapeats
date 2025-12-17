@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h1 class="fw-bold text-darkblue">
            <i class="bi bi-gear-fill me-2"></i> TapEats Admin Panel
        </h1>
        <p class="text-muted">Welcome, {{ Auth::user()->name }}. Monitor and manage the entire platform from here.</p>
    </div>
</div>

<div class="row g-4 mb-5">
    
    <!-- KPI Card: Total Registered Users -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-5 border-info">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-info fw-semibold">Total Users</div>
                        <!-- Mock data -->
                        <div class="h3 mb-0 fw-bold text-darkblue">12,450</div>
                    </div>
                    <i class="bi bi-people display-5 text-info opacity-50"></i>
                </div>
                <a href="{{ url('/admin/users') }}" class="small text-darkblue">View Details &rarr;</a>
            </div>
        </div>
    </div>

    <!-- KPI Card: Pending Supplier Approvals -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-5 border-warning">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-warning fw-semibold">Pending Suppliers</div>
                        <!-- Mock data -->
                        <div class="h3 mb-0 fw-bold text-darkblue">14</div>
                    </div>
                    <i class="bi bi-shop display-5 text-warning opacity-50"></i>
                </div>
                <a href="{{ url('/admin/suppliers') }}" class="small text-darkblue">Review Applications &rarr;</a>
            </div>
        </div>
    </div>

    <!-- KPI Card: Total Orders (Last 30 Days) -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-5 border-success">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-success fw-semibold">Orders (30 Days)</div>
                        <!-- Mock data -->
                        <div class="h3 mb-0 fw-bold text-darkblue">4,120</div>
                    </div>
                    <i class="bi bi-bag-check display-5 text-success opacity-50"></i>
                </div>
                <a href="{{ url('/admin/reports') }}" class="small text-darkblue">View Sales Report &rarr;</a>
            </div>
        </div>
    </div>

    <!-- KPI Card: System Health -->
    <div class="col-md-6 col-lg-3">
        <div class="card shadow-sm h-100 border-start border-5 border-danger">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-danger fw-semibold">Critical Errors</div>
                        <!-- Mock data -->
                        <div class="h3 mb-0 fw-bold text-darkblue">0</div>
                    </div>
                    <i class="bi bi-shield-fill-check display-5 text-danger opacity-50"></i>
                </div>
                <a href="{{ url('/superadmin/settings') }}" class="small text-darkblue">Check Logs &rarr;</a>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    
    <!-- Widget: Pending Supplier Approvals List -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-darkblue text-white fw-semibold">
                <i class="bi bi-person-badge-fill me-1"></i> New Supplier Registrations
            </div>
            <ul class="list-group list-group-flush">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    The Cozy Bakery
                    <span class="badge bg-warning rounded-pill">Awaiting Docs</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Fresh Catch Sushi
                    <span class="badge bg-warning rounded-pill">Awaiting Docs</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    Green Garden Salads
                    <button class="btn btn-sm btn-success">Approve</button>
                </li>
            </ul>
            <div class="card-footer text-center">
                <a href="{{ url('/admin/suppliers') }}" class="small fw-semibold text-darkblue">View All Pending Applications</a>
            </div>
        </div>
    </div>

    <!-- Widget: Recent System Activity Log -->
    <div class="col-lg-6">
        <div class="card shadow-sm h-100">
            <div class="card-header bg-darkblue text-white fw-semibold">
                <i class="bi bi-activity me-1"></i> Recent System Activity
            </div>
            <ul class="list-group list-group-flush small">
                <li class="list-group-item">
                    <span class="text-muted">[09:30]</span> User 'CustomerX' updated profile.
                </li>
                <li class="list-group-item">
                    <span class="text-muted">[09:25]</span> Delivery status updated for Order #901.
                </li>
                <li class="list-group-item">
                    <span class="text-muted">[09:15]</span> **Green Garden Salads** submitted documents for approval.
                </li>
                <li class="list-group-item">
                    <span class="text-muted">[09:00]</span> Scheduled database backup completed successfully.
                </li>
            </ul>
        </div>
    </div>
</div>

@endsection