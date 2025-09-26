@extends('layouts.admin')

@section('title', 'Logs - Coming Soon')

@section('page-title', 'Logs')
@section('page-description', 'System logs and activity tracking')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">Activity Logs</h4>
                </div>
                <div class="card-body">
                    @if($logs->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>User</th>
                                        <th>Action</th>
                                        <th>Model</th>
                                        <th>Description</th>
                                        <th>IP Address</th>
                                        <th>Date & Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($logs as $log)
                                        <tr>
                                            <td>
                                                @if($log->user)
                                                    {{ $log->user->name }} ({{ ucfirst($log->user_type) }})
                                                @else
                                                    Unknown
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $log->action === 'create' ? 'success' : ($log->action === 'update' ? 'warning' : ($log->action === 'delete' ? 'danger' : 'info')) }}">
                                                    {{ ucfirst($log->action) }}
                                                </span>
                                            </td>
                                            <td>{{ $log->model ?: 'N/A' }}</td>
                                            <td>{{ $log->description }}</td>
                                            <td>{{ $log->ip_address ?: 'N/A' }}</td>
                                            <td>{{ $log->created_at->format('M d, Y H:i') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex justify-content-center">
                            {{ $logs->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No activity logs found</h5>
                            <p class="text-muted">Activity logs will appear here as users perform actions.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    {{-- Extra custom styles if needed --}}
@endsection
