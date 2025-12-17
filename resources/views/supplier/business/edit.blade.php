@extends('layouts.app')

@section('title', 'Edit Business')

@section('content')
<div class="container mt-4">

    <h3>Edit Business</h3>

    <div class="card shadow-sm p-4 mt-3">

        <form action="{{ route('business.update', $business->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Business Name*</label>
                <input type="text" name="business_name" class="form-control" value="{{ $business->business_name }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Business Type</label>
                <select name="business_type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="company" {{ $business->business_type == 'company' ? 'selected' : '' }}>Company</option>
                    <option value="group" {{ $business->business_type == 'group' ? 'selected' : '' }}>Group</option>
                    <option value="individual" {{ $business->business_type == 'individual' ? 'selected' : '' }}>Individual</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control" value="{{ $business->phone_number }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Region</label>
                <input type="text" name="region" class="form-control" value="{{ $business->region }}">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control">{{ $business->address }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Current Logo</label><br>
                @if($business->logo)
                    <img src="{{ asset('storage/' . $business->logo) }}" width="100" class="rounded mb-2">
                @else
                    <p class="text-muted">No logo uploaded</p>
                @endif

                <input type="file" name="logo" class="form-control mt-2">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control">{{ $business->description }}</textarea>
            </div>

            <button class="btn btn-primary">Update Business</button>
            <a href="{{ route('business.index') }}" class="btn btn-secondary">Cancel</a>

        </form>
    </div>
</div>
@endsection
