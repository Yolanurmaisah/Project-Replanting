<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Login') - SIP-Sawit</title>
    <link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'%3E%3Ctext y='.9em' font-size='90'%3E🌴%3C/text%3E%3C/svg%3E">
    <link rel="stylesheet" href="{{ asset('css/sip.css') }}">
</head>
<body>
    <div class="auth">
        @yield('content')
    </div>
</body>
</html>
