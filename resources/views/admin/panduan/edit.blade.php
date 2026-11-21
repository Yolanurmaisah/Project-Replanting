@extends('layouts.admin.app')
@section('title', 'Ubah Panduan')

@section('content')
<div class="head">
    <div>
        <h1>Ubah Panduan</h1>
        <div class="mu">Perbarui isi atau sumber panduan</div>
    </div>
</div>

@include('admin.panduan._form')
@endsection
