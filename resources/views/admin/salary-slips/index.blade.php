@extends('layouts.admin')

@section('page-title', 'Salary Slips Management')
@section('page-description', 'Generate and manage employee salary slips')

@section('content')
<!-- Summary Statistics Cards -->
@if($salarySlips->count() > 0)
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Total Salary Slips</h5>
                <h3>{{ $salarySlips->total() }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Total Net Salary</h5>
                <h3>₹{{ number_format($salarySlips->sum('net_salary'), 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h5 class="card-title">Average Salary</h5>
                <h3>₹{{ number_format($salarySlips->avg('net_salary'), 2) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white">
            <div class="card-body text-center">
                <h5 class="card-title">This Month</h5>
                <h3>{{ $salarySlips->where('month', now()->format('Y-m'))->count() }}</h3>
            </div>
        </div>
    </div>
</div>
@endif

<div class="mb-3 d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center gap-3">
        <form method="GET" action="{{ route('salary-slips.index') }}" class="d-flex align-items-center gap-2">
            <label for="employee_id" class="form-label mb-0">Employee:</label>
            <select name="employee_id" id="employee_id" class="form-select" style="max-width: 200px;">
                <option value="">All Employees</option>
                @foreach($employees as $employee)
                    <option value="{{ $employee->id }}" {{ request('employee_id') == $employee->id ? 'selected' : '' }}>
                        {{ $employee->name }}
                    </option>
                @endforeach
            </select>

            <label for="month" class="form-label mb-0">Month:</label>
            <input type="month" id="month" name="month" value="{{ request('month') }}" class="form-control" style="max-width: 150px;">

            <label for="year" class="form-label mb-0">Year:</label>
            <input type="number" id="year" name="year" value="{{ request('year') }}" class="form-control" style="max-width: 100px;" placeholder="2024">

            <button type="submit" class="btn btn-primary">Filter</button>
        </form>
    </div>

    <a href="{{ route('salary-slips.create') }}" class="btn btn-success">
        <i class="fas fa-plus"></i> Generate New Salary Slip
    </a>
    <a href="{{ route('salary-slips.template') }}" class="btn btn-info">
        <i class="fas fa-file-alt"></i> Salary Slip Template
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Salary Slips ({{ $salarySlips->total() }} total)</h5>
    </div>
    <div class="card-body">
        @if($salarySlips->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Employee</th>
                            <th>Month/Year</th>
                            <th>Basic Salary</th>
                            <th>Gross Salary</th>
                            <th>Net Salary</th>
                            <th>Generated At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($salarySlips as $salarySlip)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($salarySlip->employee->profile_image)
                                            <img src="{{ asset('storage/' . $salarySlip->employee->profile_image) }}"
                                                 alt="Profile" class="rounded-circle me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                        @else
                                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                                                 style="width: 40px; height: 40px; font-size: 18px;">
                                                {{ strtoupper(substr($salarySlip->employee->name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="fw-bold">{{ $salarySlip->employee->name }}</div>
                                            <small class="text-muted">{{ $salarySlip->employee->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ \Carbon\Carbon::createFromFormat('Y-m', $salarySlip->month)->format('M Y') }}</span>
                                </td>
                                <td>₹{{ number_format($salarySlip->basic_salary, 2) }}</td>
                                <td>₹{{ number_format($salarySlip->gross_salary, 2) }}</td>
                                <td>
                                    <span class="fw-bold text-success">₹{{ number_format($salarySlip->net_salary, 2) }}</span>
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $salarySlip->generated_at->format('d M Y') }}<br>
                                        {{ $salarySlip->generated_at->format('h:i A') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('salary-slips.show', $salarySlip) }}"
                                           class="btn btn-outline-primary" title="View Details">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('salary-slips.edit', $salarySlip) }}"
                                           class="btn btn-outline-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('salary-slips.download-pdf', $salarySlip) }}"
                                           class="btn btn-outline-success" title="Download PDF" target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <form action="{{ route('salary-slips.destroy', $salarySlip) }}" method="POST"
                                              style="display:inline-block;"
                                              onsubmit="return confirm('Are you sure you want to delete this salary slip?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $salarySlips->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-file-invoice-dollar fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">No Salary Slips Found</h5>
                <p class="text-muted">There are no salary slips matching your criteria.</p>
                <a href="{{ route('salary-slips.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Generate First Salary Slip
                </a>
            </div>
        @endif
    </div>
</div>

<script>
// Auto-submit form when filters change
document.getElementById('employee_id').addEventListener('change', function() {
    this.closest('form').submit();
});

document.getElementById('month').addEventListener('change', function() {
    this.closest('form').submit();
});

document.getElementById('year').addEventListener('change', function() {
    this.closest('form').submit();
});
</script>
@endsection
