@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Stock Items</h3>
                    <a href="{{ route('admin.stock.create') }}" class="btn btn-primary float-end">Add New Item</a>
                    <a href="{{ route('admin.stock.assign.form') }}" class="btn btn-secondary float-end me-2">Assign Items</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Quantity</th>
                                <th>Price per Unit</th>
                                <th>Total Price</th>
                                <th>Unit</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($stockItems as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description ?? 'N/A' }}</td>
                                    <td>{{ $item->quantity }}</td>
                                    <td>{{ number_format($item->price, 2) ?? 'N/A' }}</td>
                                    <td>{{ number_format($item->quantity * $item->price, 2) ?? 'N/A' }}</td>
                                    <td>{{ $item->unit ?? 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.stock.show', $item) }}" class="btn btn-info btn-sm">View</a>
                                        <a href="{{ route('admin.stock.edit', $item) }}" class="btn btn-warning btn-sm">Edit</a>
                                        <form action="{{ route('admin.stock.destroy', $item) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{ $stockItems->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
