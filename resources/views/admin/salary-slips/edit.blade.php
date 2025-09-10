@extends('layouts.admin')

@section('page-title', 'Edit Salary Slip')
@section('page-description', 'Modify salary slip details and deductions')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Edit Salary Slip</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('salary-slips.update', $salarySlip) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="employee_id" class="form-label">Employee</label>
                            <select name="employee_id" id="employee_id" class="form-select" disabled>
                                <option value="{{ $salarySlip->employee->id }}" selected>
                                    {{ $salarySlip->employee->name }} ({{ $salarySlip->employee->email }})
                                </option>
                            </select>
                            <input type="hidden" name="employee_id" value="{{ $salarySlip->employee->id }}">
                            <div class="form-text">Employee cannot be changed after creation</div>
                        </div>
                        <div class="col-md-6">
                            <label for="month" class="form-label">Salary Month</label>
                            <input type="month" name="month" id="month" class="form-control"
                                   value="{{ $salarySlip->month }}" disabled>
                            <div class="form-text">Month cannot be changed after creation</div>
                        </div>
                    </div>

                    <!-- Employee Details Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Employee Details</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Basic Salary:</strong> ₹{{ number_format($salarySlip->basic_salary, 2) }}
                                </div>
                                <div class="mb-2">
                                    <strong>HRA:</strong> ₹{{ number_format($salarySlip->hra, 2) }}
                                </div>
                                <div class="mb-2">
                                    <strong>Conveyance:</strong> ₹{{ number_format($salarySlip->conveyance, 2) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Medical:</strong> ₹{{ number_format($salarySlip->medical, 2) }}
                                </div>
                                <div class="mb-2">
                                    <strong>Gross Salary:</strong> ₹{{ number_format($salarySlip->gross_salary, 2) }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Summary Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Attendance Summary</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-success">{{ $salarySlip->present_days }}</h5>
                                        <small>Present Days</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-danger">{{ $salarySlip->absent_days }}</h5>
                                        <small>Absent Days</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-warning">{{ $salarySlip->leave_days }}</h5>
                                        <small>Leave Days</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-info">{{ $salarySlip->half_day_count }}</h5>
                                        <small>Half Days</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Current Salary Calculation -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Current Salary Calculation</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Gross Salary:</strong> ₹{{ number_format($salarySlip->gross_salary, 2) }}
                                </div>
                                <div class="mb-2">
                                    <strong>Total Deductions:</strong> ₹{{ number_format(collect($salarySlip->deductions ?? [])->sum('amount'), 2) }}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Net Salary:</strong> <span class="text-success fw-bold">₹{{ number_format($salarySlip->net_salary, 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deductions Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Deductions</h6>
                        <div id="deductions-container">
                            @if($salarySlip->deductions && count($salarySlip->deductions) > 0)
                                @foreach($salarySlip->deductions as $index => $deduction)
                                    <div class="deduction-row mb-2">
                                        <div class="row align-items-end">
                                            <div class="col-md-6">
                                                <label class="form-label">Deduction Type</label>
                                                <input type="text" class="form-control deduction-type"
                                                       name="deductions[{{ $index + 1 }}][type]"
                                                       value="{{ $deduction['type'] }}"
                                                       placeholder="e.g., Tax, Insurance, Loan" required>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Amount</label>
                                                <input type="number" class="form-control deduction-amount"
                                                       name="deductions[{{ $index + 1 }}][amount]"
                                                       value="{{ $deduction['amount'] }}"
                                                       step="0.01" min="0" placeholder="0.00" required>
                                            </div>
                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-deduction">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="add-deduction">
                            <i class="fas fa-plus"></i> Add Deduction
                        </button>
                    </div>

                    <!-- Updated Salary Preview -->
                    <div id="salary-preview" class="mb-4" style="display: none;">
                        <h6 class="text-primary mb-3">Updated Salary Calculation Preview</h6>
                        <div class="alert alert-info">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong>Gross Salary:</strong> ₹{{ number_format($salarySlip->gross_salary, 2) }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>New Total Deductions:</strong> <span id="new-total-deductions">-</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong>New Net Salary:</strong> <span id="new-net-salary" class="text-success fw-bold">-</span>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Current Net Salary: ₹{{ number_format($salarySlip->net_salary, 2) }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('salary-slips.show', $salarySlip) }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Details
                        </a>
                        <button type="submit" class="btn btn-success" id="update-btn">
                            <i class="fas fa-save"></i> Update Salary Slip
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let deductionCount = {{ count($salarySlip->deductions ?? []) }};

document.getElementById('add-deduction').addEventListener('click', function() {
    addDeductionRow();
});

function addDeductionRow(type = '', amount = '') {
    deductionCount++;
    const container = document.getElementById('deductions-container');

    const row = document.createElement('div');
    row.className = 'deduction-row mb-2';
    row.innerHTML = `
        <div class="row align-items-end">
            <div class="col-md-6">
                <label class="form-label">Deduction Type</label>
                <input type="text" class="form-control deduction-type" name="deductions[${deductionCount}][type]"
                       value="${type}" placeholder="e.g., Tax, Insurance, Loan" required>
            </div>
            <div class="col-md-4">
                <label class="form-label">Amount</label>
                <input type="number" class="form-control deduction-amount" name="deductions[${deductionCount}][amount]"
                       value="${amount}" step="0.01" min="0" placeholder="0.00" required>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-outline-danger btn-sm remove-deduction">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;

    container.appendChild(row);

    // Add event listener to remove button
    row.querySelector('.remove-deduction').addEventListener('click', function() {
        row.remove();
        updateSalaryPreview();
    });

    // Add event listeners to update preview
    row.querySelector('.deduction-type').addEventListener('input', updateSalaryPreview);
    row.querySelector('.deduction-amount').addEventListener('input', updateSalaryPreview);
}

function updateSalaryPreview() {
    const deductions = getDeductionsData();
    const totalDeductions = deductions.reduce((sum, deduction) => sum + parseFloat(deduction.amount || 0), 0);
    const grossSalary = {{ $salarySlip->gross_salary }};
    const newNetSalary = grossSalary - totalDeductions;

    document.getElementById('new-total-deductions').textContent = '₹' + totalDeductions.toFixed(2);
    document.getElementById('new-net-salary').textContent = '₹' + Math.max(0, newNetSalary).toFixed(2);
    document.getElementById('salary-preview').style.display = 'block';
}

function getDeductionsData() {
    const deductions = [];
    const deductionRows = document.querySelectorAll('.deduction-row');

    deductionRows.forEach(row => {
        const type = row.querySelector('.deduction-type').value;
        const amount = row.querySelector('.deduction-amount').value;

        if (type && amount) {
            deductions.push({
                type: type,
                amount: parseFloat(amount)
            });
        }
    });

    return deductions;
}

// Add event listeners to existing deduction rows
document.querySelectorAll('.deduction-row').forEach(row => {
    row.querySelector('.remove-deduction').addEventListener('click', function() {
        row.remove();
        updateSalaryPreview();
    });

    row.querySelector('.deduction-type').addEventListener('input', updateSalaryPreview);
    row.querySelector('.deduction-amount').addEventListener('input', updateSalaryPreview);
});

// Show preview if there are deductions
if (document.querySelectorAll('.deduction-row').length > 0) {
    updateSalaryPreview();
}
</script>
@endsection
