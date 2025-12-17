@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3 class="mb-3">Your Menu Items</h3>

    <a href="{{ route('supplier.foods.create') }}" class="btn btn-primary mb-3">
        + Add New Food
    </a>

    <div class="card shadow">
        <div class="card-body">

            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Image</th>
                        <th>Food Name</th>
                        <th>Business</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Availability</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($foods as $food)
                        <tr>
                            <td>
                                <img src="{{ $food->image_url }}" width="50" height="50" class="rounded">
                            </td>

                            <td>{{ $food->food_name }}</td>

                            <td>
                                {{ $food->supplierBusiness->business_name }}
                            </td>

                            <td>{{ $food->category ?? '-' }}</td>

                            <td>{{ number_format($food->price, 2) }} TZS</td>

                            <td>
                                @if ($food->available)
                                    <span class="badge bg-success">Available</span>
                                @else
                                    <span class="badge bg-danger">Unavailable</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('supplier.foods.edit', $food->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('supplier.foods.destroy', $food->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
