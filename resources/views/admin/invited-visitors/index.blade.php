@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Invited Visitors</h4>
            <a href="{{ route('invited-visitors.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Invited Visitor
            </a>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Purpose</th>
                                <th>Invited At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invitedVisitors as $invitedVisitor)
                                <tr>
                                    <td>{{ $invitedVisitor->id }}</td>
                                    <td>{{ $invitedVisitor->name }}</td>
                                    <td>{{ $invitedVisitor->email ?? 'N/A' }}</td>
                                    <td>{{ $invitedVisitor->phone ?? 'N/A' }}</td>
                                    <td>{{ $invitedVisitor->purpose ?? 'N/A' }}</td>
                                    <td>{{ $invitedVisitor->invited_at ? $invitedVisitor->invited_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('invited-visitors.show', $invitedVisitor) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('invited-visitors.edit', $invitedVisitor) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('invited-visitors.destroy', $invitedVisitor) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this invited visitor?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No invited visitors found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $invitedVisitors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
