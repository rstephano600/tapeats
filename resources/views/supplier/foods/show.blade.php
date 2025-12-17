@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card mb-4">
        @if($food->image)
            <img src="{{ $food->image_url }}" class="card-img-top" alt="{{ $food->food_name }}" style="max-height:350px;object-fit:cover;">
        @endif

        <div class="card-body">
            <h5 class="card-title">{{ $food->food_name }}</h5>
            <p class="card-text text-muted small">{{ $food->category ?? 'General' }}</p>

            <p class="fw-bold text-success">Tsh {{ number_format($food->price, 2) }}</p>

            <p>{{ $food->description }}</p>

            <p class="mb-1"><strong>Business:</strong> {{ $food->supplierBusiness->business_name ?? '-' }}</p>

            <form action="{{ route('cart.add', $food->id) }}" method="POST" class="d-flex align-items-center mt-3">
                @csrf

                <div class="me-2">
                    <label class="form-label small mb-1">Qty</label>
                    <input type="number" name="quantity" value="1" min="1" class="form-control" style="width:90px;">
                </div>

                <input type="hidden" name="business_id" value="{{ $food->business_id }}">
                <input type="hidden" name="supplier_id" value="{{ $food->supplier_id }}">

                <button class="btn btn-primary me-2" type="submit">
                    <i class="bi bi-cart-plus"></i> Add to Cart
                </button>

                <a href="{{ route('cart.view') }}" class="btn btn-outline-secondary">View Cart</a>
            </form>
        </div>
    </div>
</div>
@endsection
