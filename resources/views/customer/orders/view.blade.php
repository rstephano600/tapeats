@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Order #{{ $order->id }}</h3>

    <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    <p><strong>Total Amount:</strong> Tsh {{ number_format($order->total_amount) }}</p>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Food Item</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>{{ $item->food->food_name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Tsh {{ number_format($item->price) }}</td>
                <td>Tsh {{ number_format($item->quantity * $item->price) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('customer.orders') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
