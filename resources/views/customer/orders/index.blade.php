@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>My Orders</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @foreach($orders as $order)
        <div class="card mb-3 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Order #{{ $order->id }}</h5>
                    <p class="text-muted small mb-1">
                        {{ $order->created_at->format('d M Y H:i') }}
                    </p>

                    <span class="badge 
                        @if($order->status == 'pending') bg-warning 
                        @elseif($order->status == 'accepted') bg-primary
                        @elseif($order->status == 'ready') bg-success
                        @elseif($order->status == 'rejected') bg-danger
                        @else bg-secondary 
                        @endif
                    ">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <a href="{{ route('customer.orders.view', $order->id) }}" class="btn btn-outline-primary btn-sm">
                    View Details
                </a>
            </div>
        </div>
    @endforeach
</div>
@endsection
