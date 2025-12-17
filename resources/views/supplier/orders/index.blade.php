@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="fw-bold mb-4">Customer Orders</h3>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>Total</th>
                <th>Status</th>
                <th>Date</th>
                <th>View</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->id }}</td>
                    <td>{{ $order->customer->name }}</td>
                    <td>Tsh {{ number_format($order->total_amount) }}</td>

                    <td>
                        <span class="badge bg-info text-dark">{{ ucfirst($order->status) }}</span>
                    </td>

                    <td>{{ $order->created_at->format('d M Y H:i') }}</td>

                    <td>
                        <a href="{{ route('supplier.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                            View
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div>
        {{ $orders->links() }}
    </div>

</div>
@endsection
