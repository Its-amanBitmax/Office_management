@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>Add New Stock Item</h3>
                    <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary float-end">Back</a>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.stock.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="quantity" class="form-label">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="0" required>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price per Unit</label>
                            <input type="number" step="0.01" class="form-control" id="price" name="price" min="0" placeholder="0.00">
                        </div>
                        <div class="mb-3">
                            <label for="unit" class="form-label">Unit</label>
                            <input type="text" class="form-control" id="unit" name="unit" placeholder="e.g., pieces, kg">
                        </div>
                        <div class="mb-3">
                            <label for="total_price" class="form-label">Total Price</label>
                            <input type="number" step="0.01" class="form-control" id="total_price" name="total_price" readonly>
                        </div>
                        <button type="submit" class="btn btn-primary">Create Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('quantity').addEventListener('input', calculateTotal);
    document.getElementById('price').addEventListener('input', calculateTotal);

    function calculateTotal() {
        const quantity = parseFloat(document.getElementById('quantity').value) || 0;
        const price = parseFloat(document.getElementById('price').value) || 0;
        const total = quantity * price;
        document.getElementById('total_price').value = total.toFixed(2);
    }
</script>
@endsection
