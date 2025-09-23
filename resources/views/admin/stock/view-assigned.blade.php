@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3>View Assigned Items</h3>
                    <a href="{{ route('admin.stock.index') }}" class="btn btn-secondary float-end">Back to Stock</a>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.stock.employee.assigned', ':employeeId') }}" id="viewAssignedForm">
                        @csrf
                        <div class="mb-3">
                            <label for="employee_id" class="form-label">Select Employee</label>
                            <select name="employee_id" id="employee_id" class="form-select" required>
                                <option value="">Choose an employee...</option>
                                @foreach($employees as $employee)
                                    <option value="{{ $employee->id }}">{{ $employee->name }} ({{ $employee->employee_code }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">View Assigned Items</button>
                    </form>

                    <div id="assignedItemsContainer" style="display: none; margin-top: 2rem;">
                        <h4>Assigned Items for <span id="employeeName"></span></h4>
                        <div id="assignedItemsList">
                            <!-- Assigned items will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('viewAssignedForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const employeeId = document.getElementById('employee_id').value;
    const employeeName = document.getElementById('employee_id').options[document.getElementById('employee_id').selectedIndex].text;

    if (employeeId) {
        // Update the form action with the selected employee ID
        this.action = this.action.replace(':employeeId', employeeId);

        // Show the assigned items container
        document.getElementById('assignedItemsContainer').style.display = 'block';
        document.getElementById('employeeName').textContent = employeeName;

        // Fetch assigned items via AJAX
        fetch(`/admin/stock/employee/${employeeId}/assigned`)
            .then(response => response.text())
            .then(html => {
                // Create a temporary div to parse the HTML
                const tempDiv = document.createElement('div');
                tempDiv.innerHTML = html;

                // Extract the table content
                const table = tempDiv.querySelector('.table');
                if (table) {
                    document.getElementById('assignedItemsList').innerHTML = table.outerHTML;
                } else {
                    document.getElementById('assignedItemsList').innerHTML = '<p>No items have been assigned to this employee yet.</p>';
                }
            })
            .catch(error => {
                console.error('Error fetching assigned items:', error);
                document.getElementById('assignedItemsList').innerHTML = '<p>Error loading assigned items. Please try again.</p>';
            });
    }
});
</script>
@endsection
