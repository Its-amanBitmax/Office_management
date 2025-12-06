@extends('layouts.admin')

@section('title', 'Leads')

@section('page-title', 'Leads')
@section('page-description', 'Manage your business leads')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Leads</h4>
            <a href="{{ route('admin.leads.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Lead
            </a>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.leads.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="lead_id" class="form-label">Lead ID</label>
                        <input type="text" name="lead_id" id="lead_id" class="form-control" value="{{ request('lead_id') }}" placeholder="Search lead ID...">
                    </div>

                    <div class="col-md-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ request('name') }}" placeholder="Search name...">
                    </div>

                    <div class="col-md-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" name="email" id="email" class="form-control" value="{{ request('email') }}" placeholder="Search email...">
                    </div>

                    <div class="col-md-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ request('phone') }}" placeholder="Search phone...">
                    </div>

                    <div class="col-md-3">
                        <label for="company_name" class="form-label">Company</label>
                        <input type="text" name="company_name" id="company_name" class="form-control" value="{{ request('company_name') }}" placeholder="Search company...">
                    </div>

                    <div class="col-md-3">
                        <label for="source" class="form-label">Source</label>
                        <input type="text" name="source" id="source" class="form-control" value="{{ request('source') }}" placeholder="Search source...">
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                            <option value="Closed" {{ request('status') == 'Closed' ? 'selected' : '' }}>Closed</option>
                            <option value="In Progress" {{ request('status') == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="priority" class="form-label">Priority</label>
                        <select name="priority" id="priority" class="form-select">
                            <option value="">All Priority</option>
                            <option value="Hot" {{ request('priority') == 'Hot' ? 'selected' : '' }}>Hot</option>
                            <option value="Warm" {{ request('priority') == 'Warm' ? 'selected' : '' }}>Warm</option>
                            <option value="Cold" {{ request('priority') == 'Cold' ? 'selected' : '' }}>Cold</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="assigned_to" class="form-label">Assigned To</label>
                        <select name="assigned_to" id="assigned_to" class="form-select">
                            <option value="">All Users</option>
                            @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ request('assigned_to') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.leads.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Clear
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Lead ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Company</th>
                                <th>Source</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Assigned To</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($leads as $lead)
                            <tr>
                                <td>{{ $lead->lead_id }}</td>
                                <td>{{ $lead->name }}</td>
                                <td>{{ $lead->email }}</td>
                                <td>{{ $lead->phone }}</td>
                                <td>{{ $lead->company_name }}</td>
                                <td>{{ $lead->source }}</td>
                                <td>
                                    <span class="badge bg-{{ $lead->status == 'Open' ? 'success' : ($lead->status == 'Closed' ? 'danger' : 'warning') }}">
                                        {{ $lead->status }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $lead->priority == 'Hot' ? 'danger' : ($lead->priority == 'Warm' ? 'warning' : 'secondary') }}">
                                        {{ $lead->priority }}
                                    </span>
                                </td>
                                <td>{{ $lead->assignedAdmin ? $lead->assignedAdmin->name : 'Unassigned' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.leads.show', $lead) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.leads.edit', $lead) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.leads.destroy', $lead) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">No leads found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $leads->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
