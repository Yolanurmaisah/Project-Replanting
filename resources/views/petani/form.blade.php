@extends('layouts.app')
@section('title', $petani->exists ? 'Ubah Petani' : 'Tambah Petani')

@section('content')
<div class="head">
    <div>
        <h1>{{ $petani->exists ? 'Ubah Petani' : 'Tambah Petani' }}</h1>
        <div class="mu">{{ $petani->exists ? 'Perbarui data anggota kelompok tani' : 'Daftarkan anggota baru kelompok tani' }}</div>
    </div>
</div>

<form method="POST" action="{{ $petani->exists ? route('petani.update', $petani) : route('petani.store') }}" class="card" style="max-width:760px">
    @csrf
    @if($petani->exists)
        @method('PUT')
    @endif

    <div class="row2">
        <div class="fld">
            <label for="nama">Nama lengkap</label>
            <input class="inp" id="nama" name="nama" value="{{ old('nama', $petani->nama) }}" required>
        </div>
        <div class="fld">
            <label for="nik">NIK (16 digit)</label>
            <input class="inp" id="nik" name="nik" value="{{ old('nik', $petani->nik) }}" maxlength="16" inputmode="numeric" required>
        </div>
        <div class="fld">
            <label for="no_hp">No. HP</label>
            <input class="inp" id="no_hp" name="no_hp" value="{{ old('no_hp', $petani->no_hp) }}">
        </div>
        <div class="fld">
            <label for="desa">Desa / Kelurahan</label>
            <input class="inp" id="desa" name="desa" value="{{ old('desa', $petani->desa) }}">
        </div>
    </div>
    <div class="fld">
        <label for="alamat">Alamat</label>
        <textarea class="inp" id="alamat" name="alamat">{{ old('alamat', $petani->alamat) }}</textarea>
    </div>

    <hr class="sep">
    <h2 style="margin-bottom:4px">Akun login petani <span class="mu" style="font-weight:400">(opsional)</span></h2>
    <p class="hint" style="margin:0 0 14px">Isi email dan password agar petani ini bisa masuk ke sistem dan melihat kebunnya sendiri.</p>

    <div class="row2">
        <div class="fld">
            <label for="email">Email</label>
            <input class="inp" type="email" id="email" name="email" value="{{ old('email', $petani->user?->email) }}">
        </div>
        <div class="fld">
            <label for="password">Password</label>
            <input class="inp" type="password" id="password" name="password" autocomplete="new-password">
            @if($petani->user)
                <span class="hint">Kosongkan jika tidak ingin mengubah password.</span>
            @endif
        </div>
    </div>

    <div class="acts" style="justify-content:flex-start;margin-top:8px">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('petani.index') }}" class="btn sec">Batal</a>
    </div>
</form>
@endsection
