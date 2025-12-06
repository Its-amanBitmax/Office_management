@extends('layouts.admin')

@section('title', 'Interactions')

@section('page-title', 'Interactions')
@section('page-description', 'Manage your lead interactions')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Interactions</h4>
            <a href="{{ route('admin.interactions.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Interaction
            </a>
        </div>

        <!-- Filter Form -->
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Filters</h5>
            </div>
            <div class="card-body">
                <form method="GET" action="{{ route('admin.interactions.index') }}" class="row g-3">
                    <div class="col-md-3">
                        <label for="lead_id" class="form-label">Lead</label>
                        <select name="lead_id" id="lead_id" class="form-select">
                            <option value="">All Leads</option>
                            @foreach($leads as $lead)
                            <option value="{{ $lead->id }}" {{ request('lead_id') == $lead->id ? 'selected' : '' }}>
                                {{ $lead->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="activity_type" class="form-label">Activity Type</label>
                        <select name="activity_type" id="activity_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="Call" {{ request('activity_type') == 'Call' ? 'selected' : '' }}>Call</option>
                            <option value="WhatsApp" {{ request('activity_type') == 'WhatsApp' ? 'selected' : '' }}>WhatsApp</option>
                            <option value="Email" {{ request('activity_type') == 'Email' ? 'selected' : '' }}>Email</option>
                            <option value="Meeting" {{ request('activity_type') == 'Meeting' ? 'selected' : '' }}>Meeting</option>
                            <option value="Note" {{ request('activity_type') == 'Note' ? 'selected' : '' }}>Note</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="subject" class="form-label">Subject</label>
                        <input type="text" name="subject" id="subject" class="form-control" value="{{ request('subject') }}" placeholder="Search subject...">
                    </div>

                    <div class="col-md-3">
                        <label for="activity_status" class="form-label">Status</label>
                        <select name="activity_status" id="activity_status" class="form-select">
                            <option value="">All Status</option>
                            <option value="Pending" {{ request('activity_status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                            <option value="Completed" {{ request('activity_status') == 'Completed' ? 'selected' : '' }}>Completed</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="activity_date_from" class="form-label">Activity Date From</label>
                        <input type="date" name="activity_date_from" id="activity_date_from" class="form-control" value="{{ request('activity_date_from') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="activity_date_to" class="form-label">Activity Date To</label>
                        <input type="date" name="activity_date_to" id="activity_date_to" class="form-control" value="{{ request('activity_date_to') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="next_follow_up_from" class="form-label">Next Follow Up From</label>
                        <input type="date" name="next_follow_up_from" id="next_follow_up_from" class="form-control" value="{{ request('next_follow_up_from') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="next_follow_up_to" class="form-label">Next Follow Up To</label>
                        <input type="date" name="next_follow_up_to" id="next_follow_up_to" class="form-control" value="{{ request('next_follow_up_to') }}">
                    </div>

                    <div class="col-md-3">
                        <label for="created_by" class="form-label">Created By</label>
                        <select name="created_by" id="created_by" class="form-select">
                            <option value="">All Users</option>
                            @foreach($admins as $admin)
                            <option value="{{ $admin->id }}" {{ request('created_by') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary me-2">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.interactions.index') }}" class="btn btn-secondary">
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
                                <th>ID</th>
                                <th>Lead</th>
                                <th>Activity Type</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Activity Date</th>
                                <th>Next Follow Up</th>
                                <th>Created By</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($interactions as $interaction)
                            <tr>
                                <td>{{ $interaction->id }}</td>
                                <td>{{ $interaction->lead->name ?? 'N/A' }}</td>
                                <td>{{ $interaction->activity_type }}</td>
                                <td>{{ $interaction->subject }}</td>
                                <td>
                                    <span class="badge bg-{{ $interaction->activity_status == 'Completed' ? 'success' : 'warning' }}">
                                        {{ $interaction->activity_status }}
                                    </span>
                                </td>
                                <td>{{ $interaction->activity_date ? \Carbon\Carbon::parse($interaction->activity_date)->format('d M Y') : 'N/A' }}</td>
                                <td>{{ $interaction->next_follow_up ? \Carbon\Carbon::parse($interaction->next_follow_up)->format('d M Y') : 'N/A' }}</td>
                                <td>{{ $interaction->creator->name ?? 'N/A' }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.interactions.show', $interaction) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.interactions.edit', $interaction) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.interactions.destroy', $interaction) }}" method="POST" class="d-inline">
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
                                <td colspan="9" class="text-center">No interactions found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $interactions->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
