@extends('layouts.admin.app')
@section('title', 'Ubah Kebun')

@section('content')
<div class="head">
    <div>
        <h1>Ubah Kebun</h1>
        <div class="mu">Perbarui data kebun. Untuk mengganti tahap replanting, gunakan tombol Update Tahap di halaman detail.</div>
    </div>
</div>

@include('admin.kebun._form')
@endsection
