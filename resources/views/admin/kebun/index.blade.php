@extends('layouts.admin.app')
@section('title', 'Data Kebun')

@section('content')
@php
    $kelas = ['normal' => 'ok', 'mendekati' => 'w', 'siap' => 'r'];
@endphp
<div class="head">
    <div>
        <h1>Data Kebun</h1>
        <div class="mu">Pantau umur, status, dan tahap replanting setiap kebun</div>
    </div>
    <a href="{{ route('kebun.create') }}" class="btn">+ Tambah Kebun</a>
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
                <tr>
                    <th>Kebun</th>
                    <th>Pemilik</th>
                    <th>Lokasi</th>
                    <th>Luas</th>
                    <th>Tahun Tanam</th>
                    <th>Umur</th>
                    <th>Status</th>
                    <th>Tahap</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($kebun as $k)
                    <tr>
                        <td><a href="{{ route('kebun.show', $k) }}"><b>{{ $k->nama_kebun }}</b></a></td>
                        <td>{{ $k->petani->nama }}</td>
                        <td>{{ $k->lokasi }}</td>
                        <td>{{ number_format($k->luas_ha, 1, ',', '.') }} ha</td>
                        <td>{{ $k->tahun_tanam }}</td>
                        <td>{{ $k->umur }} th</td>
                        <td><span class="b {{ $kelas[$k->status_umur] }}">{{ $k->status_label }}</span></td>
                        <td>{{ $k->tahapan->nama_tahap }}</td>
                        <td>
                            <div class="acts">
                                <a href="{{ route('kebun.show', $k) }}" class="btn sec sm">Detail</a>
                                <a href="{{ route('kebun.edit', $k) }}" class="btn sec sm">Ubah</a>
                                <form method="POST" action="{{ route('kebun.destroy', $k) }}"
                                      onsubmit="return confirm('Hapus kebun ini beserta riwayatnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn danger sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="mu" style="text-align:center;padding:32px">
                            Tidak ada data kebun{{ $status ? ' dengan status ini' : '' }}.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@endsection
