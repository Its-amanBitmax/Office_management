@extends('layouts.admin')

@section('page-title', 'Salary Management')
@section('page-description', 'Manage employee salaries and generate salary slips')

@section('content')
<div class="container-fluid">
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

    <!-- Summary Statistics Cards -->
    @if(isset($salarySlips) && $salarySlips->count() > 0)
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

    <!-- Generate New Salary Slip Section -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">
                <i class="fas fa-plus-circle"></i> Generate New Salary Slip
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.salary.store') }}" method="POST" id="salary-form">
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

                <div class="row">
                    <div class="col-md-4">
                        <label for="employee_id" class="form-label">Select Employee <span class="text-danger">*</span></label>
                        <select name="employee_id" id="employee_id" class="form-select" required>
                            <option value="">Choose employee...</option>
                            @foreach($employees ?? [] as $employee)
                                <option value="{{ $employee->id }}" {{ old('employee_id') == $employee->id ? 'selected' : '' }}>
                                    {{ $employee->name }} (ID: {{ $employee->id }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="month" class="form-label">Month <span class="text-danger">*</span></label>
                        <input type="month" name="month" id="month" class="form-control"
                               value="{{ old('month', now()->format('Y-m')) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label for="basic_salary" class="form-label">Basic Salary</label>
                        <input type="number" name="basic_salary" id="basic_salary" class="form-control"
                               step="0.01" placeholder="0.00" readonly>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-success w-100" id="generate-btn">
                            <i class="fas fa-calculator"></i> Generate
                        </button>
                    </div>
                </div>

                <!-- Employee Details (shown when employee selected) -->
                <div id="employee-details" class="mt-3" style="display: none;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6>HRA</h6>
                                    <span id="hra-amount">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6>Conveyance</h6>
                                    <span id="conveyance-amount">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-light">
                                <div class="card-body text-center">
                                    <h6>Medical</h6>
                                    <span id="medical-amount">-</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h6>Gross Salary</h6>
                                    <span id="gross-amount">-</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Existing Salary Slips Section -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-file-invoice-dollar"></i> Generated Salary Slips
            </h5>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-primary btn-sm" onclick="refreshSalaries()">
                    <i class="fas fa-sync"></i> Refresh
                </button>
            </div>
        </div>
        <div class="card-body">
            <div id="salaries-list">
                @include('admin.salary.partials.salaries-list', ['salarySlips' => $salarySlips ?? collect()])
            </div>
        </div>
    </div>
</div>

<!-- Salary Slip Modal -->
<div class="modal fade" id="salaryModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Salary Slip Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="salary-modal-body">
                <!-- Content will be loaded here -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" id="download-pdf-btn">
                    <i class="fas fa-download"></i> Download PDF
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('employee_id').addEventListener('change', function() {
    const employeeId = this.value;
    if (employeeId) {
        fetchEmployeeDetails(employeeId);
    } else {
        document.getElementById('employee-details').style.display = 'none';
        document.getElementById('basic_salary').value = '';
    }
});

function fetchEmployeeDetails(employeeId) {
    fetch(`/admin/employees/${employeeId}`)
        .then(response => response.json())
        .then(employee => {
            document.getElementById('basic_salary').value = employee.basic_salary || 0;
            document.getElementById('hra-amount').textContent = '₹' + (employee.hra || 0);
            document.getElementById('conveyance-amount').textContent = '₹' + (employee.conveyance || 0);
            document.getElementById('medical-amount').textContent = '₹' + (employee.medical || 0);

            const gross = (parseFloat(employee.basic_salary || 0) +
                          parseFloat(employee.hra || 0) +
                          parseFloat(employee.conveyance || 0) +
                          parseFloat(employee.medical || 0));
            document.getElementById('gross-amount').textContent = '₹' + gross.toFixed(2);

            document.getElementById('employee-details').style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching employee details:', error);
        });
}

function viewSalarySlip(salarySlipId) {
    fetch(`/admin/salary/${salarySlipId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('salary-modal-body').innerHTML = generateSalarySlipHTML(data);
            document.getElementById('download-pdf-btn').onclick = () => downloadPDF(salarySlipId);
            new bootstrap.Modal(document.getElementById('salaryModal')).show();
        })
        .catch(error => {
            console.error('Error fetching salary slip:', error);
        });
}

function generateSalarySlipHTML(salarySlip) {
    return `
        <div class="salary-slip-preview">
            <div class="text-center mb-4">
                <h4>Salary Slip</h4>
                <p class="text-muted">${salarySlip.employee.name} - ${salarySlip.month}</p>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <strong>Employee:</strong> ${salarySlip.employee.name}<br>
                    <strong>Month:</strong> ${salarySlip.month}<br>
                    <strong>Generated:</strong> ${new Date(salarySlip.generated_at).toLocaleDateString()}
                </div>
                <div class="col-md-6 text-end">
                    <strong>Basic Salary:</strong> ₹${parseFloat(salarySlip.basic_salary).toFixed(2)}<br>
                    <strong>Gross Salary:</strong> ₹${parseFloat(salarySlip.gross_salary).toFixed(2)}<br>
                    <strong>Net Salary:</strong> <span class="text-success fw-bold">₹${parseFloat(salarySlip.net_salary).toFixed(2)}</span>
                </div>
            </div>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Basic Salary</td>
                        <td class="text-end">₹${parseFloat(salarySlip.basic_salary).toFixed(2)}</td>
                    </tr>
                    <tr>
                        <td>HRA</td>
                        <td class="text-end">₹${parseFloat(salarySlip.hra).toFixed(2)}</td>
                    </tr>
                    <tr>
                        <td>Conveyance</td>
                        <td class="text-end">₹${parseFloat(salarySlip.conveyance).toFixed(2)}</td>
                    </tr>
                    <tr>
                        <td>Medical</td>
                        <td class="text-end">₹${parseFloat(salarySlip.medical).toFixed(2)}</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                        <td>Gross Salary</td>
                        <td class="text-end">₹${parseFloat(salarySlip.gross_salary).toFixed(2)}</td>
                    </tr>
                    ${salarySlip.deductions && salarySlip.deductions.length > 0 ?
                        salarySlip.deductions.map(deduction => `
                            <tr class="table-danger">
                                <td>${deduction.type}</td>
                                <td class="text-end">-₹${parseFloat(deduction.amount).toFixed(2)}</td>
                            </tr>
                        `).join('') +
                        `<tr class="table-danger fw-bold">
                            <td>Total Deductions</td>
                            <td class="text-end">-₹${salarySlip.deductions.reduce((sum, d) => sum + parseFloat(d.amount), 0).toFixed(2)}</td>
                        </tr>`
                        : ''
                    }
                    <tr class="table-success fw-bold">
                        <td>Net Salary</td>
                        <td class="text-end">₹${parseFloat(salarySlip.net_salary).toFixed(2)}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    `;
}

function downloadPDF(salarySlipId) {
    window.open(`/admin/salary/${salarySlipId}/download-pdf`, '_blank');
}

function deleteSalarySlip(salarySlipId) {
    if (confirm('Are you sure you want to delete this salary slip?')) {
        fetch(`/admin/salary/${salarySlipId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error deleting salary slip');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error deleting salary slip');
        });
    }
}

function refreshSalaries() {
    location.reload();
}

// Auto-load employee details if form has values
document.addEventListener('DOMContentLoaded', function() {
    const employeeSelect = document.getElementById('employee_id');
    if (employeeSelect.value) {
        fetchEmployeeDetails(employeeSelect.value);
    }
});
</script>
@endsection
