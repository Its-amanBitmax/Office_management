@extends('layouts.admin')

@section('page-title', 'Invited Visitor Card')
@section('page-description', 'Invited visitor pass with unique ID and QR code')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 text-center">
            <h3 class="mb-3">Invited Visitor Pass</h3>
            <p><strong>Name:</strong> {{ $invitedVisitor->name }}</p>
            <p><strong>Email:</strong> {{ $invitedVisitor->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $invitedVisitor->phone ?? 'N/A' }}</p>
            <p><strong>Purpose:</strong> {{ $invitedVisitor->purpose ?? 'N/A' }}</p>
            <p><strong>Invited At:</strong> {{ $invitedVisitor->invited_at ? $invitedVisitor->invited_at->format('M d, Y H:i') : 'N/A' }}</p>
            <p><strong>Unique ID:</strong> {{ $invitedVisitor->id }}</p>
            <div class="my-3">
                {!! QrCode::size(150)->generate(route('invited-visitors.show', $invitedVisitor)) !!}
            </div>
            <p>Scan this QR code for invited visitor details.</p>
        </div>
    </div>
</div>
@endsection
