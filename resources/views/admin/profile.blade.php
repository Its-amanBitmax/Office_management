@extends('layouts.admin')

@section('page-title', 'My Profile')
@section('page-description', 'View and update your profile information')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="profile-card" style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); text-align: center;">
            <div class="avatar" style="width: 100px; height: 100px; border-radius: 50%; margin: 0 auto 1rem; overflow: hidden;">
                @if($admin->profile_image)
                    <img src="{{ asset('storage/profile_images/' . $admin->profile_image) }}" alt="Profile Image" style="width: 100%; height: 100%; object-fit: cover;">
                @else
                    <div style="width: 100%; height: 100%; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-weight: bold; font-size: 2rem;">
                        {{ strtoupper(substr($admin->name, 0, 1)) }}
                    </div>
                @endif
            </div>
            <h4 style="margin: 0 0 0.5rem 0; color: #333;">{{ $admin->name }}</h4>
            <p style="margin: 0; color: #666; font-size: 0.9rem;">Administrator</p>
            <div style="margin-top: 1rem;">
                <span style="background: #28a745; color: white; padding: 0.25rem 0.75rem; border-radius: 20px; font-size: 0.8rem;">Active</span>
            </div>
        </div>

            <div class="quick-stats" style="background: white; padding: 1.5rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-top: 1rem;">
                <h5 style="color: #333; margin-bottom: 1rem;">Quick Stats</h5>
                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #666;">Last Login</span>
                        <span style="font-weight: bold; color: #333;">{{ $admin->updated_at ? $admin->updated_at->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #666;">Account Created</span>
                        <span style="font-weight: bold; color: #333;">{{ $admin->created_at ? $admin->created_at->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; align-items: center;">
                        <span style="color: #666;">Profile Updates</span>
                        <span style="font-weight: bold; color: #333;">3</span>
                    </div>
                </div>
            </div>
    </div>

    <div class="col-md-8">
        <div class="profile-form" style="background: white; padding: 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="color: #333; margin-bottom: 1.5rem; border-bottom: 2px solid #007bff; padding-bottom: 0.5rem;">Edit Profile</h4>

            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #c3e6cb;">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div style="background: #f8d7da; color: #721c24; padding: 1rem; border-radius: 4px; margin-bottom: 1rem; border: 1px solid #f5c6cb;">
                    <ul style="margin: 0; padding-left: 1rem;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $admin->name) }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $admin->email) }}" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Phone Number (Optional)</label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone', $admin->phone ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="bio" class="form-label">Bio (Optional)</label>
                    <textarea id="bio" name="bio" rows="4" class="form-control">{{ old('bio', $admin->bio ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="company_name" class="form-label">Company Name (Optional)</label>
                    <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $admin->company_name ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="company_logo" class="form-label">Company Logo (Optional)</label>
                    <input type="file" id="company_logo" name="company_logo" accept="image/*" class="form-control">
                    <small class="form-text text-muted">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                </div>

                <div class="mb-3">
                    <label for="profile_image" class="form-label">Profile Image (Optional)</label>
                    <input type="file" id="profile_image" name="profile_image" accept="image/*" class="form-control">
                    <small class="form-text text-muted">Accepted formats: JPEG, PNG, JPG, GIF. Max size: 2MB</small>
                </div>

            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="dark_mode" name="dark_mode" value="1" {{ old('dark_mode', $admin->dark_mode) ? 'checked' : '' }}>
                <label class="form-check-label" for="dark_mode">Enable Dark Mode</label>
            </div>
            <div class="d-flex gap-3">
                <button type="submit" class="btn btn-primary flex-grow-1">Update Profile</button>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary flex-grow-1 text-center">Cancel</a>
            </div>
        </form>
        </div>
    </div>

    <div class="col-md-4" style="margin-top: -24.5rem">
        <div class="password-section" style="background: white; padding: 1.5rem 2rem 2rem 2rem; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <h4 style="color: #333; margin-bottom: 1rem; border-bottom: 2px solid #dc3545; padding-bottom: 0.5rem;">Change Password</h4>

            <form method="POST" action="{{ route('admin.password.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="current_password" class="form-label">Current Password</label>
                    <input type="password" id="current_password" name="current_password" required class="form-control">
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" id="password" name="password" required class="form-control">
                </div>

                <div class="mb-1">
                    <label for="password_confirmation" class="form-label">Confirm New Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="form-control">
                </div>

                <button type="submit" class="btn btn-danger w-100">Update Password</button>
            </form>
        </div>
    </div>
</div>
@endsection
</result>
</attempt_completion>
