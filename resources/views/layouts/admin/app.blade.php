<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - SIP-Sawit</title>
    @include('layouts.admin.css')
    @stack('styles')
</head>
<body>
@php
    $user = auth()->user();
    $admin = $user->isAdmin();
    $belum = $user->notifikasi()->where('sudah_dibaca', false)->count();
    $inisial = \Illuminate\Support\Str::upper(collect(explode(' ', trim($user->name)))->filter()->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode(''));
@endphp

{{-- Kumpulan ikon SVG yang dipakai sidebar dan header --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="i-home" viewBox="0 0 24 24"><path d="M3 11l9-8 9 8v10h-6v-6H9v6H3z"/></symbol>
    <symbol id="i-users" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><path d="M3 20c0-3 3-5 6-5s6 2 6 5"/><path d="M16 5a3 3 0 010 6M18 15c2 .6 3 2.2 3 5"/></symbol>
    <symbol id="i-leaf" viewBox="0 0 24 24"><path d="M5 19C5 9 11 4 20 4c0 9-5 15-15 15z"/><path d="M5 19l8-8"/></symbol>
    <symbol id="i-book" viewBox="0 0 24 24"><path d="M4 5h7a2 2 0 012 2v12a2 2 0 00-2-2H4zM20 5h-7v14h7z"/></symbol>
    <symbol id="i-bell" viewBox="0 0 24 24"><path d="M6 16v-5a6 6 0 0112 0v5l2 2H4zM10 21h4"/></symbol>
    <symbol id="i-file" viewBox="0 0 24 24"><path d="M7 3h8l4 4v14H7zM15 3v4h4"/></symbol>
    <symbol id="i-gear" viewBox="0 0 24 24"><path d="M4 7h10M18 7h2M4 17h2M10 17h10"/><circle cx="16" cy="7" r="2"/><circle cx="8" cy="17" r="2"/></symbol>
    <symbol id="i-out" viewBox="0 0 24 24"><path d="M10 4H5v16h5M15 8l4 4-4 4M9 12h10"/></symbol>
    <symbol id="i-menu" viewBox="0 0 24 24"><path d="M4 7h16M4 12h16M4 17h16"/></symbol>
</svg>

<div class="shell">
    @include('layouts.admin.sidebar')

    <div class="main">
        @include('layouts.admin.header')

        <main class="content">
            @if(session('success'))<div class="alert ok no-print">{{ session('success') }}</div>@endif
            @if($errors->any())
                <div class="alert err"><ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul></div>
            @endif

            @yield('content')
        </main>

        @include('layouts.admin.footer')
    </div>
</div>

@include('layouts.admin.js')
@stack('scripts')
</body>
</html>
