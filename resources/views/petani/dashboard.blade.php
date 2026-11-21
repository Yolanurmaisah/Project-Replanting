@extends('layouts.admin.app')
@section('title', 'Dashboard')

@section('content')
@php
    $kelas = ['normal' => 'ok', 'mendekati' => 'w', 'siap' => 'r'];
    $siapCount = $kebun->filter(fn ($k) => $k->status_umur === 'siap')->count();
    $dekatCount = $kebun->filter(fn ($k) => $k->status_umur === 'mendekati')->count();
@endphp

<div class="head">
    <div>
        <h1>Halo, {{ auth()->user()->name }}</h1>
        <div class="mu">Pantau umur kebun dan tahap replanting milik Anda</div>
    </div>
</div>

@if(! auth()->user()->petani)
    <div class="card">
        <b>Akun Anda belum terhubung ke data petani.</b>
        <div class="mu" style="margin-top:6px">Hubungi pengurus kelompok tani agar akun Anda dihubungkan.</div>
    </div>
@else
    <section class="top3">
        <div class="hero"><b class="sp"></b>
            <div>
                <span class="tag">{{ $siapCount ? 'Peringatan' : ($dekatCount ? 'Perhatian' : 'Info') }}</span>
                <h3>
                    @if($siapCount)
                        {{ $siapCount }} kebun Anda sudah siap replanting
                    @elseif($dekatCount)
                        {{ $dekatCount }} kebun Anda mendekati masa replanting
                    @else
                        Semua kebun Anda dalam kondisi normal
                    @endif
                </h3>
            </div>
            <a href="{{ route('kebun.index') }}">Lihat kebun saya →</a>
        </div>
        <div class="card">
            <div class="mu">Jumlah Kebun</div>
            <div class="big">{{ $kebun->count() }}</div>
            <div class="up">Terdaftar atas nama Anda</div>
        </div>
        <div class="card">
            <div class="mu">Total Luas</div>
            <div class="big">{{ number_format($kebun->sum('luas_ha'), 1, ',', '.') }}</div>
            <div class="mu">hektare</div>
        </div>
    </section>

    <h2>Kebun Saya</h2>
    <section class="grid3">
        @forelse($kebun as $k)
            <a href="{{ route('kebun.show', $k) }}" class="card kb">
                <div class="head" style="align-items:center;margin-bottom:10px">
                    <h2>{{ $k->nama_kebun }}</h2>
                    <span class="b {{ $kelas[$k->status_umur] }}">{{ $k->status_label }}</span>
                </div>
                <div class="kv">
                    <div><span>Umur</span><b>{{ $k->umur }} tahun</b></div>
                    <div><span>Luas</span><b>{{ number_format($k->luas_ha, 1, ',', '.') }} ha</b></div>
                    <div><span>Tahap</span><b>{{ $k->tahapan->nama_tahap }}</b></div>
                </div>
            </a>
        @empty
            <div class="card mu">Belum ada kebun yang terdaftar atas nama Anda. Hubungi pengurus kelompok tani.</div>
        @endforelse
    </section>
@endif
@endsection
