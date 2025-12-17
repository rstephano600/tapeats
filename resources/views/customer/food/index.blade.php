@extends('layouts.app')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold">Available Foods</h2>


    </div>

    <div class="row">
        @foreach($foods as $food)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">

                    {{-- IMAGE --}}
                    @if($food->image)
                        <img src="{{ asset('storage/'.$food->image) }}" class="card-img-top" alt="Food Image">
                    @else
                        <img src="https://via.placeholder.com/300x200" class="card-img-top">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title">{{ $food->food_name }}</h5>
                        <p class="card-text text-muted small">{{ $food->category }}</p>

                        <p class="fw-bold text-success">Tsh {{ number_format($food->price) }}</p>

                        <div class="d-flex justify-content-between">

                            {{-- View Details --}}
                            <a href="{{ route('menu.foods.show',$food->id) }}" 
                               class="btn btn-primary btn-sm">
                                View Details
                            </a>



                        </div>
                    </div>

                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $foods->links() }}
    </div>

</div>
@endsection
