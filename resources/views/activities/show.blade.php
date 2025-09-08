@extends('layouts.admin')

@section('title', 'Activity Details')
@section('page-title', 'Activity Details')
@section('page-description', 'View detailed information about the activity')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">{{ $activity->title }}</h5>
                </div>
                <div class="card-body">
                    <p><strong>Description:</strong></p>
                    <p>{{ $activity->description }}</p>

                    <p><strong>Status:</strong> 
                        <span class="badge bg-{{ $activity->status == 'active' ? 'success' : ($activity->status == 'completed' ? 'secondary' : 'warning') }}">
                            {{ ucfirst($activity->status) }}
                        </span>
                    </p>

                    @if($activity->schedule_at)
                        <p><strong>Scheduled At:</strong> {{ $activity->schedule_at->format('M d, Y H:i') }}</p>
                    @endif

                    <a href="{{ route('activities.edit', $activity) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="{{ route('activities.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left"></i> Back to Activities
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
