@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Assign Items to Employees</h3>
                    <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.stock.assign') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="stock_item_id" class="form-label">Stock Item</label>
                            <select class="form-control" id="stock_item_id" name="stock_item_id" required>
                                <option value="">Select Item</option>
                                @foreach($stockItems as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} (Available: {{ $item->quantity }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select class="form-control" id="employee_id" name="employee_id" required>
                                <option value="">Select Employee</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="quantity_assigned" class="form-label">Quantity to Assign</label>
                            <input type="number" class="form-control" id="quantity_assigned" name="quantity_assigned" min="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="assigned_date" class="form-label">Assigned Date</label>
                            <input type="date" class="form-control" id="assigned_date" name="assigned_date" required>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
