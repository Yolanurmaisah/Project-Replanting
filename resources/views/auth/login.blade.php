@extends('layouts.guest')
@section('title', 'Login')
@section('content')
<div class="card">
    <div class="brand on-light" style="color:var(--tx);padding:0 0 6px"><img class="logo-ic" src="{{ asset('assets-admin/img/logo-icon.svg') }}" alt="Logo ReSawit"><span><em>Re</em>Sawit</span></div>
    <p class="mu" style="margin:0 0 20px">Sistem pemantauan & panduan replanting kelapa sawit</p>

    @if($errors->any())
        <div class="alert err" style="margin-bottom:16px">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div class="fld">
            <label for="email">Email</label>
            <input class="inp" type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <div class="fld">
            <label for="password">Password</label>
            <input class="inp" type="password" id="password" name="password" required>
        </div>
        <label style="display:flex;gap:8px;align-items:center;margin-bottom:16px">
            <input type="checkbox" name="remember"> Ingat saya
        </label>
        <button class="btn" style="width:100%">Masuk</button>
    </form>
</div>
@endsection
