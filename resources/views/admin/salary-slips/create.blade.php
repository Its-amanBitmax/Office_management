@extends('layouts.admin')

@section('page-title', 'Generate Salary Slip')
@section('page-description', 'Create a new salary slip for an employee')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Generate New Salary Slip</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('salary-slips.store') }}" method="POST">
                    @csrf

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
                            <label for="employee_id" class="form-label">Select Employee <span class="text-danger">*</span></label>
                            <select name="employee_id" id="employee_id" class="form-select" required>
                                <option value="">Choose an employee...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                        {{ $employee->name }} ({{ $employee->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="month" class="form-label">Salary Month <span class="text-danger">*</span></label>
                            <input type="month" name="month" id="month" class="form-control"
                                   value="{{ old('month', now()->format('Y-m')) }}" required>
                            <div class="form-text">Select the month for which salary is being generated</div>
                        </div>
                    </div>

                    <!-- Employee Details Section (will be populated via AJAX) -->
                    <div id="employee-details" class="mb-4" style="display: none;">
                        <h6 class="text-primary mb-3">Employee Details</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Basic Salary:</strong> <span id="basic-salary">-</span>
                                </div>
                                <div class="mb-2">
                                    <strong>HRA:</strong> <span id="hra">-</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Conveyance:</strong> <span id="conveyance">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Medical:</strong> <span id="medical">-</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Joining Date:</strong> <span id="joining-date">-</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Department:</strong> <span id="department">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Attendance Summary Section (will be populated via AJAX) -->
                    <div id="attendance-summary" class="mb-4" style="display: none;">
                        <h6 class="text-primary mb-3">Attendance Summary</h6>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-success" id="present-days">-</h5>
                                        <small>Present Days</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-danger" id="absent-days">-</h5>
                                        <small>Absent Days</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-warning" id="leave-days">-</h5>
                                        <small>Leave Days</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h5 class="text-info" id="half-days">-</h5>
                                        <small>Half Days</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Salary Calculation Preview (will be populated via AJAX) -->
                    <div id="salary-preview" class="mb-4" style="display: none;">
                        <h6 class="text-primary mb-3">Salary Calculation Preview</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Gross Salary:</strong> <span id="gross-salary">-</span>
                                </div>
                                <div class="mb-2">
                                    <strong>Total Deductions:</strong> <span id="total-deductions">-</span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-2">
                                    <strong>Net Salary:</strong> <span id="net-salary" class="text-success fw-bold">-</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Deductions Section -->
                    <div class="mb-4">
                        <h6 class="text-primary mb-3">Deductions</h6>
                        <div id="deductions-container">
                            <!-- Dynamic deduction rows will be added here -->
                        </div>
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="add-deduction">
                            <i class="fas fa-plus"></i> Add Deduction
                        </button>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('salary-slips.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to List
                        </a>
                        <button type="submit" class="btn btn-success" id="generate-btn">
                            <i class="fas fa-save"></i> Generate Salary Slip
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
let deductionCount = 0;

document.getElementById('employee_id').addEventListener('change', function() {
    const employeeId = this.value;
    const month = document.getElementById('month').value;

    if (employeeId && month) {
        fetchEmployeeData(employeeId, month);
    } else {
        hideEmployeeData();
    }
});

document.getElementById('month').addEventListener('change', function() {
    const employeeId = document.getElementById('employee_id').value;
    const month = this.value;

    if (employeeId && month) {
        fetchEmployeeData(employeeId, month);
    } else {
        hideEmployeeData();
    }
});

function fetchEmployeeData(employeeId, month) {
    fetch(`/admin/employees/${employeeId}`)
        .then(response => response.json())
        .then(employee => {
            displayEmployeeDetails(employee);
            return fetch(`/admin/attendance-data/${employeeId}/${month}`);
        })
        .then(response => response.json())
        .then(attendanceData => {
            displayAttendanceSummary(attendanceData);
            calculateSalaryPreview(employeeId, month);
        })
        .catch(error => {
            console.error('Error fetching data:', error);
            hideEmployeeData();
        });
}

function displayEmployeeDetails(employee) {
    document.getElementById('basic-salary').textContent = '₹' + (employee.basic_salary || 0);
    document.getElementById('hra').textContent = '₹' + (employee.hra || 0);
    document.getElementById('conveyance').textContent = '₹' + (employee.conveyance || 0);
    document.getElementById('medical').textContent = '₹' + (employee.medical || 0);
    document.getElementById('joining-date').textContent = employee.joining_date || '-';
    document.getElementById('department').textContent = employee.department || '-';
    document.getElementById('employee-details').style.display = 'block';
}

function displayAttendanceSummary(attendanceData) {
    document.getElementById('present-days').textContent = attendanceData.present || 0;
    document.getElementById('absent-days').textContent = attendanceData.absent || 0;
    document.getElementById('leave-days').textContent = attendanceData.leave || 0;
    document.getElementById('half-days').textContent = attendanceData.half_day || 0;
    document.getElementById('attendance-summary').style.display = 'block';
}

function calculateSalaryPreview(employeeId, month) {
    const deductions = getDeductionsData();

    fetch('/admin/calculate-salary', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            employee_id: employeeId,
            month: month,
            deductions: deductions
        })
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('gross-salary').textContent = '₹' + data.gross_salary;
        document.getElementById('total-deductions').textContent = '₹' + data.total_deductions;
        document.getElementById('net-salary').textContent = '₹' + data.net_salary;
        document.getElementById('salary-preview').style.display = 'block';
    })
    .catch(error => {
        console.error('Error calculating salary:', error);
    });
}

function hideEmployeeData() {
    document.getElementById('employee-details').style.display = 'none';
    document.getElementById('attendance-summary').style.display = 'none';
    document.getElementById('salary-preview').style.display = 'none';
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
    const employeeId = document.getElementById('employee_id').value;
    const month = document.getElementById('month').value;

    if (employeeId && month) {
        calculateSalaryPreview(employeeId, month);
    }
}

// Initialize with one empty deduction row
addDeductionRow();
</script>
@endsection
