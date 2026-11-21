@extends('layouts.admin.app')
@section('title', 'Tambah Kebun')

@section('content')
<div class="head">
    <div>
        <h1>Tambah Kebun</h1>
        <div class="mu">Daftarkan kebun kelapa sawit milik anggota</div>
    </div>
</div>

@include('admin.kebun._form')
@endsection
