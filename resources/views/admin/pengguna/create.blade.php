@extends('layouts.admin.app')
@section('title', 'Tambah Pengguna')

@section('content')
<div class="head">
    <div>
        <h1>Tambah Pengguna</h1>
        <div class="mu">Buat akun baru untuk masuk ke sistem</div>
    </div>
</div>

@include('admin.pengguna._form')
@endsection
