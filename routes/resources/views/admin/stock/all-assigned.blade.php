@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>All Assigned Items</h3>
                    <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary float-end">Back to Stock</a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if($assignedItems->count() > 0)
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Employee Name</th>
                                    <th>Stock Item</th>
                                    <th>Quantity Assigned</th>
                                    <th>Assigned Date</th>
                                    <th>Notes</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignedItems as $assignedItem)
                                    <tr>
                                        <td>{{ $assignedItem->employee->name }}</td>
                                        <td>{{ $assignedItem->stockItem->name }}</td>
                                        <td>{{ $assignedItem->quantity_assigned }}</td>
                                        <td>{{ $assignedItem->assigned_date ? $assignedItem->assigned_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>{{ $assignedItem->notes ?? 'N/A' }}</td>
                                        <td>
                                            <a href="{{ route('admin.assigned-items.edit', $assignedItem->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                            <form action="{{ route('admin.assigned-items.destroy', $assignedItem->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this assigned item?')">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No items have been assigned to any employees yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
