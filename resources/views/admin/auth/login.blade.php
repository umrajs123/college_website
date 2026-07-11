<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SCPS Admin Login</title>
    <link rel="icon" type="image/png" href="{{ asset('images/scps-logo.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ filemtime(public_path('css/admin.css')) }}">
</head>
<body class="admin-login">
    <section class="login-card">
        <div class="login-card__visual">
            <img src="{{ asset('images/scps-logo.png') }}" alt="SCPS logo">
            <span>Website Admin</span>
            <h1>Manage SCPS content with clarity.</h1>
            <p>Update homepage sections, leadership messages, faculty profiles, and admissions content from one focused dashboard.</p>
        </div>

        <form class="login-card__form" method="POST" action="{{ route('admin.login.store') }}">
            @csrf
            <span class="admin-kicker">Secure Login</span>
            <h2>Welcome Back</h2>
            <p>Use your admin credentials to continue.</p>

            <label>
                Email Address
                <input type="email" name="email" value="{{ old('email', 'admin@scps.test') }}" required autofocus>
            </label>

            <label>
                Password
                <input type="password" name="password" value="password" required>
            </label>

            <label class="admin-check">
                <input type="checkbox" name="remember" value="1">
                <span>Keep me signed in</span>
            </label>

            @error('email')
                <div class="admin-error">{{ $message }}</div>
            @enderror

            <button type="submit">Enter Admin Panel</button>
        </form>
    </section>
</body>
</html>
