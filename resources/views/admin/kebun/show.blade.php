@extends('layouts.admin.app')
@section('title', $kebun->nama_kebun)

@section('content')
@php
    $kelas = ['normal' => 'ok', 'mendekati' => 'w', 'siap' => 'r'];
@endphp
<div class="head">
    <div>
        <h1>{{ $kebun->nama_kebun }}</h1>
        <div style="margin-top:6px"><span class="b {{ $kelas[$kebun->status_umur] }}">{{ $kebun->status_label }}</span></div>
    </div>
    <div class="acts">
        <a href="{{ route('kebun.tahap', $kebun) }}" class="btn">Update Tahap</a>
        <a href="{{ route('kebun.edit', $kebun) }}" class="btn sec">Ubah</a>
        <a href="{{ route('kebun.index') }}" class="btn sec">Kembali</a>
    </div>
</div>

<section class="two-eq">
    <div class="card">
        <h2 style="margin-bottom:8px">Informasi Kebun</h2>
        <div class="kv">
            <div><span>Pemilik</span><b>{{ $kebun->petani->nama }}</b></div>
            <div><span>Lokasi</span><b>{{ $kebun->lokasi }}</b></div>
            <div><span>Luas</span><b>{{ number_format($kebun->luas_ha, 2, ',', '.') }} ha</b></div>
            <div><span>Tahun tanam</span><b>{{ $kebun->tahun_tanam }}</b></div>
            @if($kebun->tanggal_tanam_ulang)
                <div><span>Tanggal tanam ulang</span><b>{{ $kebun->tanggal_tanam_ulang->format('d-m-Y') }}</b></div>
            @endif
            <div><span>Umur</span><b>{{ $kebun->umur }} tahun</b></div>
            <div><span>Tahap saat ini</span><b>{{ $kebun->tahapan->nama_tahap }}</b></div>
        </div>
    </div>

    <div class="card">
        <h2>Panduan: {{ $kebun->tahapan->nama_tahap }}</h2>
        <div class="mu" style="margin-bottom:12px">Sesuai tahap kebun saat ini</div>
        @forelse($panduan as $p)
            <div class="guide-item">
                <b>{{ $p->judul }}</b>
                <div class="guide">{{ $p->isi }}</div>
                <div class="hint">Sumber: {{ $p->sumber }}</div>
            </div>
        @empty
            <div class="mu">Belum ada panduan untuk tahap ini.</div>
        @endforelse
    </div>
</section>

<section class="card">
    <h2 style="margin-bottom:8px">Riwayat Tahap</h2>
    <div class="sc">
        <table>
            <thead>
                <tr><th>Tanggal</th><th>Tahap</th><th>Catatan</th><th>Dicatat oleh</th><th>Foto</th></tr>
            </thead>
            <tbody>
                @forelse($riwayat as $r)
                    <tr>
                        <td>{{ $r->tanggal->format('d-m-Y') }}</td>
                        <td><span class="b ok">{{ $r->tahapan->nama_tahap }}</span></td>
                        <td>{{ $r->catatan ?: '-' }}</td>
                        <td>{{ $r->user?->name ?? '-' }}</td>
                        <td>
                            @if($r->foto)
                                <a href="{{ asset('storage/'.$r->foto) }}" target="_blank" class="b">Lihat foto</a>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="mu" style="text-align:center;padding:24px">Belum ada riwayat.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
