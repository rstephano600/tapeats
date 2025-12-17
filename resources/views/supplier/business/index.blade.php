@extends('layouts.app')

@section('title', 'My Businesses')

@section('content')
<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Your Businesses</h3>
        <a href="{{ route('business.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Business
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($businesses->isEmpty())
        <div class="alert alert-info">You have not added any business yet.</div>
    @else
        <div class="row">
            @foreach($businesses as $biz)
            <div class="col-md-6">
                <div class="card shadow-sm mb-3 border-0">
                    <div class="card-body">

                        <div class="d-flex justify-content-between">
                            <h5 class="card-title">{{ $biz->business_name }}</h5>

                            @if($biz->is_verified)
                                <span class="badge bg-success">Verified</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </div>

                        <p class="mb-1"><strong>Type:</strong> {{ $biz->business_type ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Region:</strong> {{ $biz->region ?? 'N/A' }}</p>
                        <p class="mb-1"><strong>Phone:</strong> {{ $biz->phone_number ?? 'N/A' }}</p>

                        <div class="mt-3 d-flex justify-content-between">
                            <a href="{{ route('business.edit', $biz->id) }}" class="btn btn-sm btn-secondary">
                                <i class="bi bi-pencil"></i> Edit
                            </a>

                            <form action="{{ route('business.delete', $biz->id) }}" method="POST" onsubmit="return confirm('Delete this business?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
