<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — CMS OmniRoute</title>
    <link rel="stylesheet" href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
<div class="login-wrap">
    <div class="login-card">
        <div class="logo">OmniRoute<sup>®</sup></div>
        <div class="login-sub">CMS — Panel Admin</div>

        @if ($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>
            <label class="checkbox-row">
                <input type="checkbox" name="remember" value="1"> Ingat saya
            </label>
            <button type="submit" class="btn btn-block">Masuk →</button>
        </form>

        <div class="login-meta">
            <strong>Akun demo:</strong><br>
            Admin — <code>admin@omniroute.dev</code> / <code>password</code><br>
            Editor — <code>editor@omniroute.dev</code> / <code>password</code><br>
            Sales — <code>sales@omniroute.dev</code> / <code>password</code>
        </div>
    </div>
</div>
</body>
</html>
