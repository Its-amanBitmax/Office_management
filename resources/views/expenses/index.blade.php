@extends('layouts.admin')

@section('page-title', 'Manage Expenses')
@section('page-description', 'List of all expenses')

@section('content')
<div class="content-wrapper">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Expenses</h2>
            <p class="text-muted">Manage company expenses</p>
        </div>
        <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Expense
        </a>
    </div>

    @if(auth('admin')->user()->is_super_admin ?? false)
    <!-- Monthly Report Export -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-file-excel text-success"></i> Monthly Expense Report</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.expenses.export', ['month' => date('m'), 'year' => date('Y')]) }}" method="GET" class="d-inline">
                        <div class="row g-3 align-items-end">
                            <div class="col-md-3">
                                <label for="month" class="form-label">Month</label>
                                <select name="month" id="month" class="form-select">
                                    @for($i = 1; $i <= 12; $i++)
                                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ $i == date('m') ? 'selected' : '' }}>
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="year" class="form-label">Year</label>
                                <select name="year" id="year" class="form-select">
                                    @for($y = date('Y') - 5; $y <= date('Y'); $y++)
                                        <option value="{{ $y }}" {{ $y == date('Y') ? 'selected' : '' }}>{{ $y }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-download"></i>Monthly Report
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Budget Information Card -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-wallet text-primary"></i> Expense Budget</h5>
                    <div class="d-flex align-items-center gap-2">
                        <select id="monthSelector" class="form-select form-select-sm" style="width: auto;">
                            @for($i = 1; $i <= 12; $i++)
                                <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}" {{ (isset($month) ? $month : date('m')) == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                </option>
                            @endfor
                        </select>
                        <select id="yearSelector" class="form-select form-select-sm" style="width: auto;">
                            @for($y = date('Y') - 5; $y <= date('Y'); $y++)
                                <option value="{{ $y }}" {{ (isset($year) ? $year : date('Y')) == $y ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        @if(auth('admin')->user()->is_super_admin ?? false)
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#addBudgetModal">
                                <i class="fas fa-plus"></i> Add Budget
                            </button>
                            <button class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#budgetModal">
                                <i class="fas fa-edit"></i> Set Total Budget
                            </button>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-4">
                            <div class="border-end">
                                <h4 class="text-primary">₹{{ number_format($budget->budget_amount, 2) }}</h4>
                                <p class="text-muted mb-0">Total Budget</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="border-end">
                                <h4 class="text-success">₹{{ number_format($monthlyRemaining, 2) }}</h4>
                                <p class="text-muted mb-0">Monthly Remaining</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h4 class="text-danger">₹{{ number_format($monthlySpent, 2) }}</h4>
                            <p class="text-muted mb-0">Monthly Spent</p>
                        </div>
                    </div>
                    @if($budget->remaining_amount <= 0)
                    <div class="alert alert-warning mt-3">
                        <i class="fas fa-exclamation-triangle"></i> Budget exhausted! No more expenses can be added.
                    </div>
                    @elseif($budget->remaining_amount < 1000)
                    <div class="alert alert-info mt-3">
                        <i class="fas fa-info-circle"></i> Low budget remaining. Consider replenishing.
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Budget Update Modal (for Super Admin) -->
    @if(auth('admin')->user()->is_super_admin ?? false)
    <!-- Add Budget Modal -->
    <div class="modal fade" id="addBudgetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add Budget Amount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.expenses.add-budget') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="add_amount" class="form-label">Amount to Add</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" id="add_amount" name="add_amount" step="0.01" min="0" required>
                            </div>
                            <div class="form-text">Enter the amount to add to the current budget.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Budget</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Set Total Budget Modal -->
    <div class="modal fade" id="budgetModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Set Total Expense Budget</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.expenses.update-budget') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="budget_amount" class="form-label">New Total Budget Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">₹</span>
                                <input type="number" class="form-control" id="budget_amount" name="budget_amount" step="0.01" min="0" value="{{ $budget->budget_amount }}" required>
                            </div>
                            <div class="form-text">Enter the new total budget. Remaining will be adjusted accordingly.</div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Set Total Budget</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Amount</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th>Created By</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr>
                                <td>{{ $expense->title }}</td>
                                <td>₹{{ number_format($expense->amount, 2) }}</td>
                                <td>{{ $expense->category }}</td>
                                <td>{{ $expense->expense_date->format('M d, Y') }}</td>
                                <td>{{ $expense->admin->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('admin.expenses.edit', $expense) }}" class="btn btn-sm btn-outline-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.expenses.destroy', $expense) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this expense?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-receipt fa-3x mb-3"></i>
                                        <p>No expenses found.</p>
                                        <a href="{{ route('admin.expenses.create') }}" class="btn btn-primary">Add First Expense</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($expenses->hasPages())
                <div class="d-flex justify-content-center">
                    {{ $expenses->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

<script>
document.getElementById('monthSelector').addEventListener('change', function() {
    const selectedMonth = this.value;
    const selectedYear = document.getElementById('yearSelector').value;
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('month', selectedMonth);
    currentUrl.searchParams.set('year', selectedYear);
    window.location.href = currentUrl.toString();
});

document.getElementById('yearSelector').addEventListener('change', function() {
    const selectedYear = this.value;
    const selectedMonth = document.getElementById('monthSelector').value;
    const currentUrl = new URL(window.location);
    currentUrl.searchParams.set('month', selectedMonth);
    currentUrl.searchParams.set('year', selectedYear);
    window.location.href = currentUrl.toString();
});
</script>
