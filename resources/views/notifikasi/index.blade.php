@extends('layouts.admin.app')
@section('title', 'Notifikasi')

@section('content')
@php
    $kelas = ['siap' => 'r', 'mendekati' => 'w', 'tahap' => 'ok'];
    $label = ['siap' => 'Siap replanting', 'mendekati' => 'Mendekati replanting', 'tahap' => 'Update tahap'];
@endphp
<div class="head">
    <div>
        <h1>Notifikasi</h1>
        <div class="mu">Peringatan umur kebun dan perubahan tahap replanting</div>
    </div>
    <form method="POST" action="{{ route('notifikasi.baca-semua') }}">
        @csrf
        <button type="submit" class="btn sec">Tandai semua dibaca</button>
    </form>
</div>

<section class="card">
    @forelse($notifikasi as $n)
        <div class="notif {{ $n->sudah_dibaca ? '' : 'baru' }}">
            <div class="meta">
                <span><b>{{ $n->judul }}</b> <span class="b {{ $kelas[$n->jenis] }}">{{ $label[$n->jenis] }}</span></span>
                <span class="mu">{{ $n->created_at->format('d-m-Y H:i') }}</span>
            </div>
            <div>{{ $n->pesan }}</div>
            <div class="acts" style="justify-content:flex-start">
                @if($n->kebun)
                    <a href="{{ route('kebun.show', $n->kebun) }}" class="btn sec sm">Lihat kebun</a>
                @endif
                @unless($n->sudah_dibaca)
                    <form method="POST" action="{{ route('notifikasi.baca', $n) }}">
                        @csrf
                        <button type="submit" class="btn sec sm">Tandai dibaca</button>
                    </form>
                @endunless
            </div>
        </div>
    @empty
        <div class="mu" style="text-align:center;padding:32px">Belum ada notifikasi.</div>
    @endforelse

    {{ $notifikasi->links('vendor.pagination.sip') }}
</section>
@endsection
