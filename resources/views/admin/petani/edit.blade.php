@extends('layouts.admin.app')
@section('title', 'Ubah Petani')

@section('content')
<div class="head">
    <div>
        <h1>Ubah Petani</h1>
        <div class="mu">Perbarui data anggota kelompok tani</div>
    </div>
</div>

@include('admin.petani._form')
@endsection
