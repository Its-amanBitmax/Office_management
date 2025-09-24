@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Assigned Item</h3>
                    <a href="{{ route('admin.stock.all-assigned') }}" class="btn btn-secondary float-end">Back to All Assigned Items</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.assigned-items.update', $assignedItem->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="stock_item_id" class="form-label">Stock Item</label>
                            <select name="stock_item_id" id="stock_item_id" class="form-control" required>
                                @foreach($stockItems as $stockItem)
                                    <option value="{{ $stockItem->id }}" {{ $assignedItem->stock_item_id == $stockItem->id ? 'selected' : '' }}>{{ $stockItem->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select name="employee_id" id="employee_id" class="form-control" required>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ $assignedItem->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->name }} ({{ $employee->employee_code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="quantity_assigned" class="form-label">Quantity Assigned</label>
                            <input type="number" name="quantity_assigned" id="quantity_assigned" class="form-control" value="{{ $assignedItem->quantity_assigned }}" min="1" required>
                        </div>

                        <div class="mb-3">
                            <label for="assigned_date" class="form-label">Assigned Date</label>
                            <input type="date" name="assigned_date" id="assigned_date" class="form-control" value="{{ $assignedItem->assigned_date->format('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea name="notes" id="notes" class="form-control" rows="3">{{ $assignedItem->notes }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Assigned Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
