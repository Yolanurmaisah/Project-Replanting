@extends('layouts.admin.app')
@section('title', 'Ubah Pengguna')

@section('content')
<div class="head">
    <div>
        <h1>Ubah Pengguna</h1>
        <div class="mu">Perbarui data akun</div>
    </div>
</div>

@include('admin.pengguna._form')
@endsection
