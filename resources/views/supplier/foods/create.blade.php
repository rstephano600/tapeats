@extends('layouts.app')

@section('content')
<div class="container mt-4">

    <h3>Add New Food Item</h3>

    <form action="{{ route('supplier.foods.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card mt-3">
            <div class="card-body">

                <div class="mb-3">
                    <label>Business / Canteen</label>
                    <select name="business_id" class="form-control" required>
                        <option value="">Select Business</option>
                        @foreach ($businesses as $business)
                            <option value="{{ $business->id }}">{{ $business->business_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label>Food Name</label>
                    <input type="text" name="food_name" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Category</label>
                    <input type="text" name="category" class="form-control" placeholder="e.g Rice, Drinks">
                </div>

                <div class="mb-3">
                    <label>Price (TZS)</label>
                    <input type="number" name="price" step="0.01" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label>Food Image</label>
                    <input type="file" name="image" class="form-control">
                </div>

                <div class="mb-3">
                    <label>Description</label>
                    <textarea name="description" rows="3" class="form-control"></textarea>
                </div>

                <button class="btn btn-primary">Save</button>

            </div>
        </div>

    </form>

</div>
@endsection
