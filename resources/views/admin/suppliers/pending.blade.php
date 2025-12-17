@extends('layouts.app')

@section('title', 'Business Approval Panel')

@section('content')
<div class="container mt-4">

    <h3 class="mb-4">Pending Business Approvals</h3>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-body">

            @if($suppliers->count() == 0)
                <p class="text-muted text-center">No businesses waiting for approval.</p>
            @else
                <table class="table table-striped align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Business Name</th>
                            <th>Owner</th>
                            <th>Phone</th>
                            <th>Type</th>
                            <th>Region</th>
                            <th>Description</th>
                            <th>Logo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        @foreach($suppliers as $supplier)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>{{ $supplier->business_name }}</td>

                                <td>
                                    {{ $supplier->user->name }} <br>
                                    <small class="text-muted">{{ $supplier->user->email }}</small>
                                </td>

                                <td>{{ $supplier->phone_number }}</td>

                                <td>
                                    <span class="badge bg-info">
                                        {{ ucfirst($supplier->business_type) }}
                                    </span>
                                </td>

                                <td>{{ $supplier->region }}</td>

                                <td style="max-width: 180px;">
                                    <small>{{ $supplier->description }}</small>
                                </td>

                                <td>
                                    <img src="{{ $supplier->logo_url }}" width="40" height="40" class="rounded">
                                </td>

                                <td>
                                    <span class="badge bg-warning text-dark">Pending</span>
                                </td>

                                <td>
                                    <form method="POST" action="{{ route('admin.suppliers.verify', $supplier->id) }}">
                                        @csrf
                                        <button class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Approve
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            @endif

        </div>
    </div>
</div>
@endsection
