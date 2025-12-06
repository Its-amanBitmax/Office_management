@extends('layouts.admin')

@section('title', 'Executives')

@section('page-title', 'Executives')
@section('page-description', 'Executive performance and statistics')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Executive Performance</h4>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Executive Name</th>
                                <th>Total Leads</th>
                                <th>Approved Leads</th>
                                <th>Lead Conversion Rate</th>
                                <th>Total Proposals</th>
                                <th>Approved Proposals</th>
                                <th>Proposal Conversion Rate</th>
                                <th>Total Interactions</th>
                                <th>Total Approvals</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($executiveStats as $stat)
                            <tr>
                                <td>{{ $stat['executive']->name }}</td>
                                <td>{{ $stat['total_leads'] }}</td>
                                <td>
                                    <span class="badge bg-success">{{ $stat['approved_leads'] }}</span>
                                </td>
                                <td>{{ $stat['lead_conversion_rate'] }}%</td>
                                <td>{{ $stat['total_proposals'] }}</td>
                                <td>
                                    <span class="badge bg-primary">{{ $stat['approved_proposals'] }}</span>
                                </td>
                                <td>{{ $stat['proposal_conversion_rate'] }}%</td>
                                <td>{{ $stat['total_interactions'] }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $stat['total_approvals'] }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.executives.show', $stat['executive']->id) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i> View Details
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="10" class="text-center">No executives found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
