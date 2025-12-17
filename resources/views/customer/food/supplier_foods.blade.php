@extends('layouts.app')

@section('content')
<div class="container py-4">

    <h2 class="mb-4 fw-bold">{{ $supplier->business_name }} — Menu</h2>

    <div class="row">
        @foreach($foods as $food)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">

                    @if($food->image)
                        <img src="{{ asset('storage/'.$food->image) }}" class="card-img-top" alt="">
                    @else
                        <img src="https://via.placeholder.com/300x200" class="card-img-top">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $food->food_name }}</h5>
                        <p class="card-text text-muted small">{{ $food->category }}</p>

                        <p class="fw-bold text-success">Tsh {{ number_format($food->price) }}</p>

                        <a href="{{ route('menu.show',$food->id) }}" class="btn btn-outline-primary btn-sm">
                            Order Now
                        </a>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

</div>
@endsection
