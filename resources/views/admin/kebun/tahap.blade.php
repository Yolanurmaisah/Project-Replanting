@extends('layouts.admin.app')
@section('title', 'Update Tahap')

@section('content')
<div class="head">
    <div>
        <h1>Update Tahap Replanting</h1>
        <div class="mu">{{ $kebun->nama_kebun }} &middot; {{ $kebun->petani->nama }} &middot; tahap saat ini: <b>{{ $kebun->tahapan->nama_tahap }}</b></div>
    </div>
</div>

<form method="POST" action="{{ route('kebun.tahap.update', $kebun) }}" enctype="multipart/form-data" class="card" style="max-width:760px">
    @csrf

    <div class="row2">
        <div class="fld">
            <label for="tahapan_id">Tahap baru</label>
            <select class="inp" id="tahapan_id" name="tahapan_id" required>
                @foreach($daftarTahap as $t)
                    <option value="{{ $t->id }}" @selected(old('tahapan_id', $kebun->tahapan_id) == $t->id)>{{ $t->urutan }}. {{ $t->nama_tahap }}</option>
                @endforeach
            </select>
        </div>
        <div class="fld">
            <label for="tanggal">Tanggal kegiatan</label>
            <input class="inp" type="date" id="tanggal" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required>
        </div>
    </div>

    <div class="fld">
        <label for="catatan">Catatan kegiatan</label>
        <textarea class="inp" id="catatan" name="catatan">{{ old('catatan') }}</textarea>
    </div>

    <div class="row2">
        <div class="fld">
            <label for="foto">Foto dokumentasi <span class="mu" style="font-weight:400">(opsional)</span></label>
            <input class="inp" type="file" id="foto" name="foto" accept="image/*" style="padding-top:9px">
            <span class="hint">Format gambar, maksimal 2 MB.</span>
        </div>
        <div class="fld">
            <label for="tanggal_tanam_ulang">Tanggal tanam ulang <span class="mu" style="font-weight:400">(opsional)</span></label>
            <input class="inp" type="date" id="tanggal_tanam_ulang" name="tanggal_tanam_ulang" value="{{ old('tanggal_tanam_ulang', $kebun->tanggal_tanam_ulang?->toDateString()) }}">
            <span class="hint">Isi saat tahap Penanaman. Umur kebun lalu dihitung ulang dari tahun tanam ulang.</span>
        </div>
    </div>

    <div class="acts" style="justify-content:flex-start;margin-top:8px">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('kebun.show', $kebun) }}" class="btn sec">Batal</a>
    </div>
</form>
@endsection
