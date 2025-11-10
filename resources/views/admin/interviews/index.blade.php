@extends('layouts.admin')

@section('page-title', 'Interviews Management')
@section('page-description', 'Manage interview schedules and records')

@section('content')
<div class="mb-3 d-flex justify-content-between align-items-center">
    <div>
        <h4>Interviews</h4>
        <p class="text-muted">Manage all interview schedules and details</p>
    </div>
    <a href="{{ route('admin.interviews.create') }}" class="btn btn-primary">Schedule New Interview</a>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Code</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Profile</th>
                        <th>Experience</th>
                        <th>Status</th>
                        <th>Results</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($interviews as $interview)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $interview->interview_code ?: 'N/A' }}</td>
                            <td>{{ $interview->candidate_name }}</td>
                            <td>{{ $interview->candidate_email }}</td>
                            <td>{{ $interview->candidate_phone ?: 'N/A' }}</td>
                            <td>{{ Str::limit($interview->candidate_profile, 50) ?: 'N/A' }}</td>
                            <td>{{ Str::limit($interview->candidate_experience, 50) ?: 'N/A' }}</td>
                            <td>
                                <span class="badge
                                    @if($interview->status == 'scheduled') bg-primary
                                    @elseif($interview->status == 'completed') bg-success
                                    @elseif($interview->status == 'cancelled') bg-danger
                                    @elseif($interview->status == 'rescheduled') bg-warning
                                    @endif">
                                    {{ ucfirst($interview->status) }}
                                </span>
                            </td>
                             <td>
                                @if($interview->results)
                                    <span class="badge
                                        @if($interview->results == 'selected') bg-success
                                        @elseif($interview->results == 'rejected') bg-danger
                                        @elseif($interview->results == 'pending') bg-warning
                                        @endif">
                                        {{ ucfirst($interview->results) }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.interviews.show', $interview) }}" class="btn btn-info btn-sm" title="View">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.interviews.edit', $interview) }}" class="btn btn-warning btn-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    @if($interview->interview_code && $interview->password)
                                        <a href="{{ route('admin.interviews.room', $interview) }}" class="btn btn-success btn-sm" title="Start Interview" target="_blank">
                                            <i class="fas fa-play"></i>
                                        </a>
                                    @endif
                                    <form action="{{ route('admin.interviews.destroy', $interview) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this interview?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="text-center">No interviews found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($interviews->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $interviews->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
