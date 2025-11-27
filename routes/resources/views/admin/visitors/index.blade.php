@extends('layouts.admin')
<div>
@section('page-title', 'Visitors')
@section('page-description', 'Manage visitors')
  <a href="{{ route('visitors.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Visitor
            </a>
</div>
@section('content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Visitors</h4>
            <a href="{{ route('visitors.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add Visitor
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
                                <th>Visited At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($visitors as $visitor)
                                <tr>
                                    <td>{{ $visitor->id }}</td>
                                    <td>{{ $visitor->name }}</td>
                                    <td>{{ $visitor->email ?? 'N/A' }}</td>
                                    <td>{{ $visitor->phone ?? 'N/A' }}</td>
                                    <td>{{ $visitor->purpose ?? 'N/A' }}</td>
                                    <td>{{ $visitor->visited_at ? $visitor->visited_at->format('M d, Y H:i') : 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('visitors.show', $visitor) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('visitors.edit', $visitor) }}" class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('visitors.destroy', $visitor) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this visitor?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">No visitors found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $visitors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
