@extends('layouts.admin.app')
@section('title', 'Kebun Saya')

@section('content')
@php
    $kelas = ['normal' => 'ok', 'mendekati' => 'w', 'siap' => 'r'];
@endphp
<div class="head">
    <div>
        <h1>Kebun Saya</h1>
        <div class="mu">Daftar kebun milik Anda beserta umur dan tahap replanting</div>
    </div>
</div>

<div class="chips">
    <a href="{{ route('kebun.index') }}" class="chip {{ $status ? '' : 'on' }}">Semua</a>
    <a href="{{ route('kebun.index', ['status' => 'normal']) }}" class="chip {{ $status === 'normal' ? 'on' : '' }}">Normal</a>
    <a href="{{ route('kebun.index', ['status' => 'mendekati']) }}" class="chip {{ $status === 'mendekati' ? 'on' : '' }}">Mendekati Replanting</a>
    <a href="{{ route('kebun.index', ['status' => 'siap']) }}" class="chip {{ $status === 'siap' ? 'on' : '' }}">Siap Replanting</a>
</div>

<section class="card">
    <div class="sc">
        <table>
            <thead>
                <tr><th>Kebun</th><th>Lokasi</th><th>Luas</th><th>Tahun Tanam</th><th>Umur</th><th>Status</th><th>Tahap</th><th></th></tr>
            </thead>
            <tbody>
                @forelse($kebun as $k)
                    <tr>
                        <td><a href="{{ route('kebun.show', $k) }}"><b>{{ $k->nama_kebun }}</b></a></td>
                        <td>{{ $k->lokasi }}</td>
                        <td>{{ number_format($k->luas_ha, 1, ',', '.') }} ha</td>
                        <td>{{ $k->tahun_tanam }}</td>
                        <td>{{ $k->umur }} th</td>
                        <td><span class="b {{ $kelas[$k->status_umur] }}">{{ $k->status_label }}</span></td>
                        <td>{{ $k->tahapan->nama_tahap }}</td>
                        <td><div class="acts"><a href="{{ route('kebun.show', $k) }}" class="btn sec sm">Detail</a></div></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="mu" style="text-align:center;padding:32px">
                            Tidak ada kebun{{ $status ? ' dengan status ini' : '' }}.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
