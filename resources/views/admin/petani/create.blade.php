@extends('layouts.admin.app')
@section('title', 'Tambah Petani')

@section('content')
<div class="head">
    <div>
        <h1>Tambah Petani</h1>
        <div class="mu">Daftarkan anggota baru kelompok tani</div>
    </div>
</div>

@include('admin.petani._form')
@endsection
