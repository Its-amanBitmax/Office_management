@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Stock Item Details</h3>
                    <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Name:</strong>
                            <p>{{ $stockItem->name }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Description:</strong>
                            <p>{{ $stockItem->description ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Quantity:</strong>
                            <p>{{ $stockItem->quantity }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Price per Unit:</strong>
                            <p>{{ number_format($stockItem->price, 2) ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Total Price:</strong>
                            <p>{{ number_format($stockItem->quantity * $stockItem->price, 2) ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Unit:</strong>
                            <p>{{ $stockItem->unit ?? 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Created At:</strong>
                            <p>{{ $stockItem->created_at ? $stockItem->created_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
                        </div>
                        <div class="col-md-6">
                            <strong>Updated At:</strong>
                            <p>{{ $stockItem->updated_at ? $stockItem->updated_at->format('Y-m-d H:i:s') : 'N/A' }}</p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.stock.edit', $stockItem) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('admin.stock.destroy', $stockItem) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
