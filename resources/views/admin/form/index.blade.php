@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard')
@section('page-description', 'Quick actions & recent activity')

@section('content')

{{-- Quick Action Cards --}}
<div class="row g-4 mb-4">

    {{-- Trip Form Card --}}
    <div class="col-sm-6 col-lg-3">
        <div class="card h-100 shadow-sm border-0"
            onclick="window.location.href='{{ url('/admin/form/trip') }}'"
            style="cursor:pointer">

            <div class="card-img-top d-flex align-items-center justify-content-center text-white"
                style="height:130px; background:linear-gradient(135deg,#4f46e5,#7c3aed)">
                <i class="fa-solid fa-plane-departure fa-3x"></i>
            </div>

            <div class="card-body">
                <h5 class="card-title fw-semibold">Trip Form</h5>
                <p class="card-text text-muted small">
                    Create and manage employee trip requests
                </p>

                <div class="btn btn-primary w-100">
                    <i class="fa-solid fa-arrow-right me-1"></i> Open Form
                </div>
            </div>
        </div>
    </div>

</div>

{{-- Recent Trip Forms --}}
<div class="card shadow-sm border-0">

    {{-- Header --}}
    <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-semibold">Recent Trip Forms</h5>
        <span class="badge bg-secondary">
            Total: {{ $forms->count() }}
        </span>
    </div>

    {{-- Table --}}
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light text-uppercase small">
                <tr>
                    <th>#</th>
                    <th>Form Code</th>
                    <th>Created</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>

            <tbody>
                @forelse($forms as $form)
                    <tr>
                        <td class="fw-medium">{{ $loop->iteration }}</td>

                        <td>
                            <span class="badge bg-primary-subtle text-primary">
                                {{ $form->form_code }}
                            </span>
                        </td>

                        <td>
                            <div class="fw-medium">
                                {{ $form->created_at->format('d M Y') }}
                            </div>
                            <small class="text-muted">
                                {{ $form->created_at->format('h:i A') }}
                            </small>
                        </td>

                        <td class="text-center">
                          

                            <a href="{{ route('admin.form.edit', $form->id) }}"
                                class="btn btn-sm btn-outline-success">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            {{-- Delete --}}
        <form action="{{ route('admin.form.destroy', $form->id) }}"
              method="POST"
              onsubmit="return confirm('Are you sure you want to delete this form?')"
              class="d-inline">
            @csrf
            @method('DELETE')

            <button type="submit"
                class="btn btn-sm btn-outline-danger"
                title="Delete">
                <i class="fa-solid fa-trash"></i>
            </button>
        </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="fa-regular fa-folder-open fa-2x mb-2 d-block"></i>
                            No trip forms found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
