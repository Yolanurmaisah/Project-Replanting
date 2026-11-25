<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Login') - ReSawit</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('assets-admin/img/logo-icon.svg') }}">
    <link rel="stylesheet" href="{{ asset('assets-admin/css/sip.css') }}">
</head>
<body>
    <div class="auth">
        @yield('content')
    </div>
</body>
</html>
