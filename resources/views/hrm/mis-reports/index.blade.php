@extends('layouts.admin')

@section('title', 'HR MIS Reports')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
    <h3 class="card-title mb-0">HR MIS Reports</h3>

    <a href="{{ route('hr-mis-reports.create') }}"
       class="btn btn-primary">
        Create New Report
    </a>
</div>

                <div class="card-body">
                    <div class="row">
                        @forelse($reports as $report)
                        <div class="col-md-6 col-lg-4 mb-4">
                            <div class="card h-100">
                                <div class="card-header">
                                    <h5 class="card-title mb-0">{{ ucfirst($report->report_type) }} Report</h5>
                                    <small class="text-muted">Created: {{ $report->created_at->format('Y-m-d H:i') }}</small>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>Report Date:</strong><br>
                                        <span class="text-primary">
                                            {{ $report->report_date ? $report->report_date->format('Y-m-d') : ($report->week_start ? $report->week_start->format('Y-m-d') . ' - ' . $report->week_end->format('Y-m-d') : ($report->report_month ?? 'N/A')) }}
                                        </span>
                                    </div>
                                    @if($report->department)
                                    <div class="mb-2">
                                        <strong>Department:</strong><br>
                                        <span>{{ $report->department }}</span>
                                    </div>
                                    @endif
                                    <div class="mb-2">
                                        <strong>Reported By:</strong><br>
                                        <span>{{ $report->createdBy ? $report->createdBy->name : 'N/A' }}</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="btn-group w-100" role="group">
                                        <a href="{{ route('hr-mis-reports.show', $report->id) }}" class="btn btn-sm btn-outline-info">View</a>
                                        <a href="{{ route('hr-mis-reports.edit', $report->id) }}" class="btn btn-sm btn-outline-warning">Edit</a>
                                        <a href="{{ route('hr-mis-reports.download-pdf', $report->id) }}" class="btn btn-sm btn-outline-success" target="_blank">
                                            <i class="fas fa-download"></i> PDF
                                        </a>
                                        <form action="{{ route('hr-mis-reports.destroy', $report->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body text-center">
                                    <p class="mb-0">No reports found.</p>
                                </div>
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
