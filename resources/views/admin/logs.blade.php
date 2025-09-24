@extends('layouts.admin')

@section('title', 'Logs - Coming Soon')

@section('page-title', 'Logs')
@section('page-description', 'System logs and activity tracking')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-8 text-center">
            <div class="coming-soon-container" style="padding: 4rem 2rem; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 20px; color: white; margin: 2rem 0;">
                <div style="font-size: 6rem; margin-bottom: 1rem;">🚧</div>
                <h1 style="font-size: 3rem; font-weight: bold; margin-bottom: 1rem;">Coming Soon</h1>
                <p style="font-size: 1.2rem; margin-bottom: 2rem; opacity: 0.9;">
                    We're working hard to bring you the Logs feature. This module will help you track system activities, user actions, and important events.
                </p>

                <div style="background: rgba(255, 255, 255, 0.1); border-radius: 10px; padding: 2rem; margin: 2rem 0;">
                    <h3 style="margin-bottom: 1rem;">What to Expect:</h3>
                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; text-align: left;">
                        <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📊</div>
                            <strong>Activity Tracking</strong>
                            <p style="font-size: 0.9rem; opacity: 0.8; margin: 0;">Monitor user activities and system events</p>
                        </div>
                        <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">🔍</div>
                            <strong>Audit Trail</strong>
                            <p style="font-size: 0.9rem; opacity: 0.8; margin: 0;">Complete audit trail for compliance</p>
                        </div>
                        <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">⚡</div>
                            <strong>Real-time Updates</strong>
                            <p style="font-size: 0.9rem; opacity: 0.8; margin: 0;">Live monitoring and notifications</p>
                        </div>
                        <div style="background: rgba(255, 255, 255, 0.1); padding: 1rem; border-radius: 8px;">
                            <div style="font-size: 1.5rem; margin-bottom: 0.5rem;">📈</div>
                            <strong>Analytics</strong>
                            <p style="font-size: 0.9rem; opacity: 0.8; margin: 0;">Detailed reports and insights</p>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 2rem;">
                    <p style="opacity: 0.8; margin-bottom: 1rem;">Expected Release: Q2 2024</p>
                    <button onclick="history.back()" style="background: rgba(255, 255, 255, 0.2); color: white; border: 2px solid rgba(255, 255, 255, 0.3); padding: 0.75rem 2rem; border-radius: 25px; cursor: pointer; font-size: 1rem; transition: all 0.3s ease;">
                        ← Back to Dashboard
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .coming-soon-container {
        animation: fadeInUp 0.8s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .coming-soon-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        transition: all 0.3s ease;
    }
</style>
@endsection
