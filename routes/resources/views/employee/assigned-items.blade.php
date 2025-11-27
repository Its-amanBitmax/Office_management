@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3>My Assigned Items</h3>
                </div>
                <div class="card-body">
                    @if($assignedItems->isEmpty())
                        <p>No items assigned yet.</p>
                    @else
                        <div class="mb-3">
                            <h5>Assigned Items Array:</h5>
                            <pre>{{ json_encode($assignedItems->map(function($item) {
                                return [
                                    'id' => $item->id,
                                    'item_name' => $item->stockItem->name,
                                    'quantity_assigned' => $item->quantity_assigned,
                                    'price_per_unit' => $item->stockItem->price,
                                    'total_value' => $item->quantity_assigned * $item->stockItem->price,
                                    'assigned_date' => $item->assigned_date->format('Y-m-d'),
                                    'notes' => $item->notes,
                                ];
                            })->toArray(), JSON_PRETTY_PRINT) }}</pre>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Quantity Assigned</th>
                                    <th>Price per Unit</th>
                                    <th>Total Value</th>
                                    <th>Assigned Date</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($assignedItems as $item)
                                    <tr>
                                        <td>{{ $item->stockItem->name }}</td>
                                        <td>{{ $item->quantity_assigned }}</td>
                                        <td>${{ number_format($item->stockItem->price, 2) ?? 'N/A' }}</td>
                                        <td>${{ number_format($item->quantity_assigned * $item->stockItem->price, 2) ?? 'N/A' }}</td>
                                        <td>{{ $item->assigned_date->format('Y-m-d') }}</td>
                                        <td>{{ $item->notes ?? 'N/A' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
