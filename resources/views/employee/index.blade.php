@extends('layouts.admin')

@section('title', 'Employees')
@section('page-title', 'Employees Management')
@section('page-description', 'Manage employee records and details')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-dark font-weight-bold">Employees List</h4>
        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-plus me-2"></i>Add New Employee
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 rounded-lg">
        <div class="card-header bg-white border-bottom py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="input-group">
                        <span class="input-group-text bg-light"><i class="fas fa-search"></i></span>
                        <input type="text" class="form-control" placeholder="Search employees..." id="searchInput">
                    </div>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select class="form-select" id="departmentFilter" aria-label="Filter by department">
                        <option value="">All Departments</option>
                        @foreach($departments as $department)
                            <option value="{{ $department }}">{{ $department }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Employee Code</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Position</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th class="text-end pe-4">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="employeeTable">
                        @forelse($employees as $employee)
                            <tr>
                                <td class="ps-4">{{ $employee->id }}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($employee->profile_image)
                                            <img src="{{ asset('storage/' . $employee->profile_image) }}" alt="{{ $employee->name }} Profile" class="rounded-circle me-2" width="40" height="40">
                                        @endif
                                        <span>{{ $employee->employee_code }}</span>
                                    </div>
                                </td>
                                <td>{{ $employee->name }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->phone ?? 'N/A' }}</td>
                                <td>{{ $employee->position ?? 'N/A' }}</td>
                                <td>{{ $employee->department ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $employee->status === 'active' ? 'success' : 'secondary' }} rounded-pill px-3 py-2">
                                        {{ ucfirst($employee->status) }}
                                    </span>
                                </td>
                                <td class="text-end pe-4">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-sm btn-outline-info rounded-circle mx-1" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-sm btn-outline-warning rounded-circle mx-1" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="d-inline"
                                              onsubmit="return confirm('Are you sure you want to delete this employee?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger rounded-circle mx-1" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-5">
                                    <div class="text-muted">
                                        <i class="fas fa-users fa-3x mb-3 opacity-25"></i>
                                        <p class="mb-3">No employees found.</p>
                                        <a href="{{ route('employees.create') }}" class="btn btn-primary btn-sm shadow-sm">
                                            <i class="fas fa-plus me-2"></i>Add First Employee
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($employees->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $employees->links('pagination::bootstrap-5') }}
        </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const statusFilter = document.getElementById('statusFilter');
    const departmentFilter = document.getElementById('departmentFilter');
    const tableRows = document.querySelectorAll('#employeeTable tr');

    function filterTable() {
        const searchText = searchInput.value.toLowerCase();
        const statusValue = statusFilter.value.toLowerCase();
        const departmentValue = departmentFilter.value.toLowerCase();

        tableRows.forEach(row => {
            const cells = row.querySelectorAll('td');
            if (cells.length === 0) return;

            const code = cells[1].textContent.toLowerCase();
            const name = cells[2].textContent.toLowerCase();
            const email = cells[3].textContent.toLowerCase();
            const phone = cells[4].textContent.toLowerCase();
            const position = cells[5].textContent.toLowerCase();
            const department = cells[6].textContent.toLowerCase();
            const status = cells[7].textContent.toLowerCase();

            const matchesSearch = code.includes(searchText) || 
                                name.includes(searchText) || 
                                email.includes(searchText) || 
                                phone.includes(searchText) || 
                                position.includes(searchText) || 
                                department.includes(searchText);
            
            const matchesStatus = !statusValue || status.includes(statusValue);
            const matchesDepartment = !departmentValue || department.includes(departmentValue);

            row.style.display = matchesSearch && matchesStatus && matchesDepartment ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    statusFilter.addEventListener('change', filterTable);
    departmentFilter.addEventListener('change', filterTable);
});
</script>

<style>
.card {
    transition: all 0.3s ease;
}
.card:hover {
    box-shadow: 0 8px 24px rgba(0,0,0,0.1) !important;
}
.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.85rem;
    letter-spacing: 0.5px;
}
.table td {
    vertical-align: middle;
}
.btn-outline-info, .btn-outline-warning, .btn-outline-danger {
    width: 36px;
    height: 36px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s ease;
}
.btn-outline-info:hover {
    background-color: #0dcaf0;
    color: white;
}
.btn-outline-warning:hover {
    background-color: #ffc107;
    color: white;
}
.btn-outline-danger:hover {
    background-color: #dc3545;
    color: white;
}
.badge {
    font-size: 0.9rem;
    font-weight: 500;
}
</style>
@endsection