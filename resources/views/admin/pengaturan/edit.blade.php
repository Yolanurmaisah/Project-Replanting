@extends('layouts.admin.app')
@section('title', 'Pengaturan')

@section('content')
<div class="head">
    <div>
        <h1>Pengaturan Ambang Umur</h1>
        <div class="mu">Menentukan kapan kebun dianggap mendekati atau siap replanting</div>
    </div>
</div>

<div class="two-eq">
    <form method="POST" action="{{ route('pengaturan.update') }}" class="card">
        @csrf
        @method('PUT')

        <div class="fld">
            <label for="batas_mendekati">Mulai “Mendekati Replanting” (tahun)</label>
            <input class="inp" type="number" min="1" max="60" id="batas_mendekati" name="batas_mendekati" value="{{ old('batas_mendekati', $mendekati) }}" required>
        </div>
        <div class="fld">
            <label for="batas_siap">Mulai “Siap Replanting” (tahun)</label>
            <input class="inp" type="number" min="1" max="60" id="batas_siap" name="batas_siap" value="{{ old('batas_siap', $siap) }}" required>
            <span class="hint">Harus lebih besar dari batas “Mendekati”. Sesuaikan dengan ketentuan PSR yang berlaku.</span>
        </div>

        <div class="acts" style="justify-content:flex-start;margin-top:8px">
            <button type="submit" class="btn">Simpan</button>
        </div>
    </form>

    <div class="card">
        <h2 style="margin-bottom:8px">Aturan yang berlaku sekarang</h2>
        <div class="kv">
            <div><span>Normal</span><b>di bawah {{ $mendekati }} tahun</b></div>
            <div><span>Mendekati Replanting</span><b>{{ $mendekati }} sampai {{ $siap - 1 }} tahun</b></div>
            <div><span>Siap Replanting</span><b>{{ $siap }} tahun ke atas</b></div>
        </div>
        <p class="hint" style="margin-top:14px">Perubahan langsung memengaruhi status semua kebun, dashboard, dan notifikasi berikutnya.</p>
    </div>
</div>
@endsection
