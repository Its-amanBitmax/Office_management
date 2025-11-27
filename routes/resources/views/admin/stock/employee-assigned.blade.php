@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>Assigned Items for {{ $employee->name }}</h3>
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
                                    <th>Price per Unit</th>
                                    <th>Total Value</th>
                                    <th>Assigned Date</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignedItems as $assignedItem)
                                    <tr>
                                        <td>{{ $assignedItem->employee->name }}</td>
                                        <td>{{ $assignedItem->stockItem->name }}</td>
                                        <td>{{ $assignedItem->quantity_assigned }}</td>
                                        <td>${{ number_format($assignedItem->stockItem->price, 2) }}</td>
                                        <td>${{ number_format($assignedItem->quantity_assigned * $assignedItem->stockItem->price, 2) }}</td>
                                        <td>{{ $assignedItem->assigned_date ? $assignedItem->assigned_date->format('Y-m-d') : 'N/A' }}</td>
                                        <td>{{ $assignedItem->notes ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>No items have been assigned to this employee yet.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
