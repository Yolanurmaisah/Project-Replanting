@extends('layouts.admin.app')
@section('title', 'Tambah Panduan')

@section('content')
<div class="head">
    <div>
        <h1>Tambah Panduan</h1>
        <div class="mu">Tulis panduan untuk salah satu tahap replanting</div>
    </div>
</div>

@include('admin.panduan._form')
@endsection
