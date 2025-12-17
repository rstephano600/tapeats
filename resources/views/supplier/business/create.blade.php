@extends('layouts.app')

@section('title', 'Add Business')

@section('content')
<div class="container mt-4">

    <h3>Add New Business</h3>

    <div class="card shadow-sm p-4 mt-3">
        <form action="{{ route('business.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Business Name*</label>
                <input type="text" name="business_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Business Type</label>
                <select name="business_type" class="form-control">
                    <option value="">Select Type</option>
                    <option value="company">Company</option>
                    <option value="group">Group</option>
                    <option value="individual">Individual</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Phone Number</label>
                <input type="text" name="phone_number" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Region</label>
                <input type="text" name="region" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Logo</label>
                <input type="file" name="logo" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control"></textarea>
            </div>

            <button class="btn btn-primary">Save Business</button>
            <a href="{{ route('business.index') }}" class="btn btn-secondary">Cancel</a>

        </form>
    </div>
</div>
@endsection
