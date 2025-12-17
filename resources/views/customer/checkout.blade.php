@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>Checkout</h3>

    <div class="card shadow mt-3">
        <div class="card-body">

            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Food</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Total</th>
                    </tr>
                </thead>

                <tbody>
                    @php $grandTotal = 0; @endphp
                    @foreach($cart as $id => $item)
                        @php $total = $item['price'] * $item['quantity']; @endphp
                        @php $grandTotal += $total; @endphp

                        <tr>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['price'], 2) }}</td>
                            <td>{{ number_format($total, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

            <h4>Total: <strong>{{ number_format($grandTotal, 2) }} TZS</strong></h4>

            <form action="{{ route('order.place') }}" method="POST">
                @csrf
                <button class="btn btn-success mt-3">Place Order</button>
            </form>

        </div>
    </div>

</div>
@endsection
