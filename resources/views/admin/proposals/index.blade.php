@extends('layouts.admin')

@section('title', 'Proposals')

@section('page-title', 'Proposals')
@section('page-description', 'Manage your lead proposals')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Proposals</h4>
            <a href="{{ route('admin.proposals.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Proposal
            </a>
        </div>

        <!-- Filters -->
        <div class="card mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('admin.proposals.index') }}" class="row g-3">
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
                        <label for="proposal_no" class="form-label">Proposal No</label>
                        <input type="text" name="proposal_no" id="proposal_no" class="form-control"
                               value="{{ request('proposal_no') }}" placeholder="Search by proposal no">
                    </div>

                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="sent" {{ request('status') == 'sent' ? 'selected' : '' }}>Sent</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label for="amount_min" class="form-label">Amount Range</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="amount_min" class="form-control"
                                   value="{{ request('amount_min') }}" placeholder="Min">
                            <input type="number" step="0.01" name="amount_max" class="form-control"
                                   value="{{ request('amount_max') }}" placeholder="Max">
                        </div>
                    </div>

                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.proposals.index') }}" class="btn btn-secondary">
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
                                <th>Proposal No</th>
                                <th>Lead</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>File</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($proposals as $proposal)
                            <tr>
                                <td>{{ $proposal->proposal_no }}</td>
                                <td>{{ $proposal->lead->name ?? 'N/A' }}</td>
                                <td>${{ number_format($proposal->amount, 2) }}</td>
                                <td>
                                    <span class="badge bg-{{ $proposal->status == 'approved' ? 'success' : ($proposal->status == 'rejected' ? 'danger' : 'warning') }}">
                                        {{ ucfirst($proposal->status) }}
                                    </span>
                                </td>
                                <td>
                                    @if($proposal->file)
                                        <a href="{{ Storage::url($proposal->file) }}" target="_blank" class="btn btn-sm btn-info">
                                            <i class="fas fa-file-pdf"></i> View
                                        </a>
                                    @else
                                        No file
                                    @endif
                                </td>
                                <td>{{ $proposal->created_at->format('d M Y') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.proposals.show', $proposal) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.proposals.edit', $proposal) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.proposals.destroy', $proposal) }}" method="POST" class="d-inline">
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
                                <td colspan="7" class="text-center">No proposals found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{ $proposals->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
