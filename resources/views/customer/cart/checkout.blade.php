@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Checkout</h3>

    <div class="card mt-3">
        <div class="card-body">
            <table class="table">
                <thead><tr><th>Item</th><th>Qty</th><th>Price</th><th>Total</th></tr></thead>
                <tbody>
                    @php $grand = 0; @endphp
                    @foreach($cart as $id=>$item)
                        @php $line = $item['price']*$item['quantity']; $grand += $line; @endphp
                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'],2) }}</td>
                            <td>{{ number_format($line,2) }}</td>
                        </tr>
                    @endforeach
                    <tr><td colspan="3" class="text-end"><strong>Total</strong></td><td><strong>{{ number_format($grand,2) }}</strong></td></tr>
                </tbody>
            </table>

            <form action="{{ route('order.place') }}" method="POST">
                @csrf
                <button class="btn btn-success">Place Order</button>
                <a href="{{ route('cart.view') }}" class="btn btn-secondary">Back to Cart</a>
            </form>
        </div>
    </div>
</div>
@endsection
