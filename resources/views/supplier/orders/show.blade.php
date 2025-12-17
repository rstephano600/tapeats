@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-3">Order #{{ $order->id }}</h3>

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Customer:</strong> {{ $order->customer->name }}</p>
            <p><strong>Total Amount:</strong> Tsh {{ number_format($order->total_amount) }}</p>
            <p><strong>Status:</strong> 
                <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
            </p>
        </div>
    </div>

    <h4 class="fw-bold">Items</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Food</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($order->items as $item)
            <tr>
                <td>{{ $item->food->food_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Tsh {{ number_format($item->price) }}</td>
                <td>Tsh {{ number_format($item->price * $item->quantity) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h4 class="fw-bold mt-4">Update Status</h4>

    <form method="POST" action="{{ route('supplier.orders.status', $order->id) }}">
        @csrf

        <select name="status" class="form-select mb-3" required>
            <option value="pending" {{ $order->status=='pending'?'selected':'' }}>Pending</option>
            <option value="approved" {{ $order->status=='approved'?'selected':'' }}>Approved</option>
            <option value="preparing" {{ $order->status=='preparing'?'selected':'' }}>Preparing</option>
            <option value="ready" {{ $order->status=='ready'?'selected':'' }}>Ready</option>
            <option value="delivered" {{ $order->status=='delivered'?'selected':'' }}>Delivered</option>
            <option value="rejected" {{ $order->status=='rejected'?'selected':'' }}>Rejected</option>
        </select>

        <button class="btn btn-success">Update Status</button>
    </form>

</div>
@endsection
