@extends('layouts.admin')

@section('page-title', 'Salary Slip Details')
@section('page-description', 'View detailed salary slip information')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Salary Slip Details</h5>
                <div class="btn-group" role="group">
                    <a href="{{ route('salary-slips.edit', $salarySlip) }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('salary-slips.download-pdf', $salarySlip) }}" class="btn btn-success btn-sm" target="_blank">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
                    <form action="{{ route('salary-slips.destroy', $salarySlip) }}" method="POST" style="display:inline-block;"
                          onsubmit="return confirm('Are you sure you want to delete this salary slip?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i> Delete
                        </button>
                    </form>
                               <form action="{{ route('salary-slips.send-to-documents', $salarySlip) }}"
      method="POST"
      style="display:inline-block;"
      onsubmit="return confirm('Send salary slip to employee documents?');">
    @csrf
    <button type="submit" class="btn btn-primary btn-sm">
        <i class="fas fa-paper-plane"></i> Send
    </button>
</form>
                </div>
            </div>
            <div class="card-body">
                <!-- Employee Information -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-primary">Employee Information</h6>
                        <div class="mb-2">
                            <strong>Name:</strong> {{ $salarySlip->employee->name }}
                        </div>
                        <div class="mb-2">
                            <strong>Email:</strong> {{ $salarySlip->employee->email }}
                        </div>
                        <div class="mb-2">
                            <strong>Employee Code:</strong> {{ $salarySlip->employee->employee_code }}
                        </div>
                        <div class="mb-2">
                            <strong>Joining Date:</strong> {{ $salarySlip->employee->hire_date ? \Carbon\Carbon::parse($salarySlip->employee->hire_date)->format('d M Y') : 'N/A' }}
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Salary Slip Information</h6>
                        <div class="mb-2">
                            <strong>Month/Year:</strong> {{ \Carbon\Carbon::createFromFormat('Y-m', $salarySlip->month)->format('F Y') }}
                        </div>
                        <div class="mb-2">
                            <strong>Generated At:</strong> {{ $salarySlip->generated_at->format('d M Y, h:i A') }}
                        </div>
                        <div class="mb-2">
                            <strong>Slip ID:</strong> {{ $salarySlip->slip_id }}
                        </div>
                    </div>
                </div>

                <!-- Salary Breakdown -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h6 class="text-primary">Earnings</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Basic Salary</td>
                                <td class="text-end">₹{{ number_format($salarySlip->basic_salary, 2) }}</td>
                            </tr>
                            <tr>
                                <td>HRA</td>
                                <td class="text-end">₹{{ number_format($salarySlip->hra, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Conveyance</td>
                                <td class="text-end">₹{{ number_format($salarySlip->conveyance, 2) }}</td>
                            </tr>
                            <tr>
                                <td>Medical</td>
                                <td class="text-end">₹{{ number_format($salarySlip->medical, 2) }}</td>
                            </tr>
                            <tr class="table-active fw-bold">
                                <td>Gross Salary</td>
                                <td class="text-end">₹{{ number_format($salarySlip->gross_salary, 2) }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary">Attendance Summary</h6>
                        <table class="table table-sm">
                            <tr>
                                <td>Total Working Days</td>
                                <td class="text-end">{{ $salarySlip->total_working_days }}</td>
                            </tr>
                            <tr class="text-success">
                                <td>Present Days</td>
                                <td class="text-end">{{ $salarySlip->present_days }}</td>
                            </tr>
                            <tr class="text-danger">
                                <td>Absent Days</td>
                                <td class="text-end">{{ $salarySlip->absent_days }}</td>
                            </tr>
                            <tr class="text-warning">
                                <td>Leave Days</td>
                                <td class="text-end">{{ $salarySlip->leave_days }}</td>
                            </tr>
                            <tr class="text-info">
                                <td>Half Days</td>
                                <td class="text-end">{{ $salarySlip->half_day_count }}</td>
                            </tr>
                            <tr class="text-primary">
                                <td>Holidays</td>
                                <td class="text-end">{{ $salarySlip->holiday_days ?? 0 }}</td>
                            </tr>
                            <tr class="text-danger">
                                <td>NCNS</td>
                                <td class="text-end">{{ $salarySlip->ncns_days ?? 0 }}</td>
                            </tr>
                            <tr class="text-danger">
                                <td>LWP</td>
                                <td class="text-end">{{ $salarySlip->lwp_days ?? 0 }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Deductions -->
                @if($salarySlip->deductions && count($salarySlip->deductions) > 0)
                    <div class="mb-4">
                        <h6 class="text-primary">Deductions</h6>
                        <table class="table table-sm">
                            @foreach($salarySlip->deductions as $deduction)
                                <tr>
                                    <td>{{ $deduction['type'] }}</td>
                                    <td class="text-end">₹{{ number_format($deduction['amount'], 2) }}</td>
                                </tr>
                            @endforeach
                            <tr class="table-active fw-bold">
                                <td>Total Deductions</td>
                                <td class="text-end">₹{{ number_format(collect($salarySlip->deductions)->sum('amount'), 2) }}</td>
                            </tr>
                        </table>
                    </div>
                @endif

                <!-- Net Salary -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h4 class="mb-0">Net Salary: ₹{{ number_format($salarySlip->net_salary, 2) }}</h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <!-- Quick Actions -->
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0">Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('salary-slips.edit', $salarySlip) }}" class="btn btn-warning">
                        <i class="fas fa-edit"></i> Edit Salary Slip
                    </a>
                    <a href="{{ route('salary-slips.download-pdf', $salarySlip) }}" class="btn btn-success" target="_blank">
                        <i class="fas fa-download"></i> Download PDF
                    </a>
         

                    <a href="{{ route('salary-slips.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <!-- Salary Slip Summary -->
        <div class="card mt-3">
            <div class="card-header">
                <h6 class="mb-0">Summary</h6>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <small class="text-muted">Gross Salary</small>
                    <div class="fw-bold">₹{{ number_format($salarySlip->gross_salary, 2) }}</div>
                </div>
                <div class="mb-2">
                    <small class="text-muted">Total Deductions</small>
                    <div class="fw-bold text-danger">
                        -₹{{ number_format(collect($salarySlip->deductions ?? [])->sum('amount'), 2) }}
                    </div>
                </div>
                <hr>
                <div>
                    <small class="text-muted">Net Salary</small>
                    <div class="fw-bold text-success fs-5">₹{{ number_format($salarySlip->net_salary, 2) }}</div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show mt-3">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif
@endsection