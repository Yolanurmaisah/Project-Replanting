@extends('layouts.admin.app')
@section('title', 'Profil Saya')

@section('content')
<div class="head">
    <div>
        <h1>Profil Saya</h1>
        <div class="mu">Kelola data akun dan foto profil Anda</div>
    </div>
</div>

<form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="card" style="max-width:760px">
    @csrf
    @method('PUT')

    <div style="display:flex;gap:20px;align-items:center;flex-wrap:wrap;margin-bottom:20px">
        <div class="av-lg" id="avatar-besar">
            @if($pengguna->foto_url)
                <img src="{{ $pengguna->foto_url }}" alt="Foto profil">
            @else
                {{ $pengguna->inisial }}
            @endif
        </div>
        <div style="flex:1;min-width:220px">
            <div class="fld" style="margin-bottom:8px">
                <label for="foto">Foto profil</label>
                <input class="inp" type="file" id="foto" name="foto" accept="image/png,image/jpeg,image/webp" style="padding-top:9px">
                <span class="hint">Format JPG, PNG, atau WEBP. Maksimal 2 MB.</span>
            </div>
            @if($pengguna->foto)
                <button type="submit" form="hapus-foto" class="btn danger sm" onclick="return confirm('Hapus foto profil?')">Hapus foto</button>
            @endif
        </div>
    </div>

    <hr class="sep">

    <div class="row2">
        <div class="fld">
            <label for="name">Nama</label>
            <input class="inp" id="name" name="name" value="{{ old('name', $pengguna->name) }}" {{ $pengguna->isAdmin() ? 'required' : 'readonly' }}>
            @unless($pengguna->isAdmin())
                <span class="hint">Nama petani diubah oleh admin lewat menu Data Petani.</span>
            @endunless
        </div>
        <div class="fld">
            <label for="email">Email (untuk login)</label>
            <input class="inp" type="email" id="email" name="email" value="{{ old('email', $pengguna->email) }}" required>
        </div>
    </div>

    <div class="fld">
        <label>Peran</label>
        <div><span class="b {{ $pengguna->isAdmin() ? 'ok' : '' }}">{{ $pengguna->isAdmin() ? 'Admin / Pengurus' : 'Petani' }}</span></div>
    </div>

    <hr class="sep">
    <h2 style="margin-bottom:4px">Ganti password <span class="mu" style="font-weight:400">(opsional)</span></h2>
    <p class="hint" style="margin:0 0 14px">Kosongkan bagian ini jika tidak ingin mengubah password.</p>

    <div class="row2">
        <div class="fld">
            <label for="password_lama">Password saat ini</label>
            <input class="inp" type="password" id="password_lama" name="password_lama" autocomplete="current-password">
        </div>
        <div class="fld"></div>
        <div class="fld">
            <label for="password">Password baru</label>
            <input class="inp" type="password" id="password" name="password" autocomplete="new-password">
            <span class="hint">Minimal 6 karakter.</span>
        </div>
        <div class="fld">
            <label for="password_confirmation">Ulangi password baru</label>
            <input class="inp" type="password" id="password_confirmation" name="password_confirmation" autocomplete="new-password">
        </div>
    </div>

    <div class="acts" style="justify-content:flex-start;margin-top:8px">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('dashboard') }}" class="btn sec">Batal</a>
    </div>
</form>

<form id="hapus-foto" method="POST" action="{{ route('profil.foto.hapus') }}">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
// Pratinjau foto sebelum disimpan
document.getElementById('foto').addEventListener('change', function () {
    var f = this.files[0];
    if (!f) return;
    var box = document.getElementById('avatar-besar');
    box.innerHTML = '';
    var img = document.createElement('img');
    img.src = URL.createObjectURL(f);
    img.alt = 'Pratinjau foto';
    box.appendChild(img);
});
</script>
@endpush
