@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Your Cart</h3>

    @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
    @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

    @if(empty($cart))
        <div class="alert alert-info">Your cart is empty.</div>
    @else
        <div class="card">
            <div class="card-body">
                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Price</th>
                            <th style="width:120px">Qty</th>
                            <th>Total</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $grand = 0; @endphp
                        @foreach($cart as $id => $item)
                            @php $line = $item['price'] * $item['quantity']; $grand += $line; @endphp
                            <tr>
                                <td>

                                    <strong>{{ $item['name'] }}</strong><br>
                                    <small class="text-muted">Business: {{ \App\Models\Supplier::find($item['business_id'])->business_name ?? '-' }}</small>
                                </td>
                                <td>{{ number_format($item['price'], 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.update', $id) }}" method="POST" class="d-flex">
                                        @csrf
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="form-control form-control-sm me-2">
                                        <button class="btn btn-sm btn-outline-primary">Update</button>
                                    </form>
                                </td>
                                <td>{{ number_format($line, 2) }}</td>
                                <td>
                                    <form action="{{ route('cart.remove', $id) }}" method="POST" onsubmit="return confirm('Remove item?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-sm btn-danger">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        <tr>
                            <td colspan="3" class="text-end"><strong>Total</strong></td>
                            <td><strong>{{ number_format($grand, 2) }}</strong></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>

                <div class="d-flex justify-content-between">
                    <a href="{{ url()->previous() }}" class="btn btn-secondary">Continue Browsing</a>

                    <a href="{{ route('checkout') }}" class="btn btn-success">Proceed to Checkout</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
