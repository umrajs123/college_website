@extends('admin.layouts.app')

@section('title', 'Admin Security')
@section('eyebrow', 'Account Protection')
@section('page_title', 'Security')

@section('content')
    <section class="admin-form-shell">
        <form class="admin-form-card" method="POST" action="{{ route('admin.security.update') }}">
            @csrf
            @method('PUT')

            <div class="admin-card-head">
                <div>
                    <span class="admin-kicker">Password Access</span>
                    <h2>Update Admin Password</h2>
                    <p>Use a strong password before sharing the dashboard with real content editors.</p>
                </div>
            </div>

            <div class="admin-form-grid">
                <label class="span-2">
                    Current Password
                    <input type="password" name="current_password" autocomplete="current-password" required>
                    @error('current_password') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    New Password
                    <input type="password" name="password" autocomplete="new-password" required>
                    @error('password') <small class="field-error">{{ $message }}</small> @enderror
                </label>

                <label>
                    Confirm New Password
                    <input type="password" name="password_confirmation" autocomplete="new-password" required>
                </label>
            </div>

            <div class="admin-form-actions">
                <button type="submit">Save Password</button>
                <a href="{{ route('admin.dashboard') }}">Back to Dashboard</a>
            </div>
        </form>

        <aside class="admin-preview-card">
            <span class="admin-kicker">Quick Guidance</span>
            <h3>Recommended Password</h3>
            <p>Use at least 10 characters with uppercase, lowercase, and numbers. Avoid college name, staff names, or simple dates.</p>
        </aside>
    </section>
@endsection
