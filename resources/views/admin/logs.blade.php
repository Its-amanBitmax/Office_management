@extends('layouts.admin')

@section('title', 'Logs - Coming Soon')

@section('page-title', 'Logs')
@section('page-description', 'System logs and activity tracking')

@section('content')
<div class="d-flex flex-column align-items-center justify-content-center py-5" style="min-height:60vh; text-align:center; background: linear-gradient(135deg, #c2bdcb, #2f45ec); color:#fff;">
    <h1 style="font-size:2.5rem; font-weight:600;">We’re Launching Soon 🚀</h1>
    <p style="max-width:600px; font-size:1.1rem; margin-top:1rem;">
        Our website is currently under construction. We’re working hard to give you the best experience. Stay tuned!
    </p>
    <form class="newsletter mt-3 d-flex flex-column flex-sm-row justify-content-center align-items-center">
        <input type="email" class="form-control mb-2 mb-sm-0 me-sm-2" placeholder="Enter your email" style="width:250px;">
        <button type="submit" class="btn btn-light fw-bold text-primary">Notify Me</button>
    </form>
</div>
@endsection

@section('styles')
    {{-- Extra custom styles if needed --}}
@endsection
