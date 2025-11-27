@extends('layouts.admin')

@section('page-title', 'Visitor Card')
@section('page-description', 'Visitor pass with unique ID and QR code')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card p-4 text-center">
            <h3 class="mb-3">Visitor Pass</h3>
            <p><strong>Name:</strong> {{ $visitor->name }}</p>
            <p><strong>Email:</strong> {{ $visitor->email ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $visitor->phone ?? 'N/A' }}</p>
            <p><strong>Purpose:</strong> {{ $visitor->purpose ?? 'N/A' }}</p>
            <p><strong>Visited At:</strong> {{ $visitor->visited_at ? $visitor->visited_at->format('M d, Y H:i') : 'N/A' }}</p>
            <p><strong>Unique ID:</strong> {{ $visitor->id }}</p>
            <div class="my-3">
                {!! QrCode::size(150)->generate(route('visitors.show', $visitor)) !!}
            </div>
            <p>Scan this QR code for visitor details.</p>
        </div>
    </div>
</div>
@endsection
