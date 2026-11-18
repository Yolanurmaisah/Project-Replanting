@extends('layouts.app')
@section('title', 'Data Petani')

@section('content')
<div class="head">
    <div>
        <h1>Data Petani</h1>
        <div class="mu">Kelola data anggota kelompok tani</div>
    </div>
    <a href="{{ route('petani.create') }}" class="btn">+ Tambah Petani</a>
</div>

<section class="card">
    <div class="sc">
        <table>
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIK</th>
                    <th>No. HP</th>
                    <th>Desa</th>
                    <th>Kebun</th>
                    <th>Akun Login</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse($petani as $p)
                    <tr>
                        <td><b>{{ $p->nama }}</b></td>
                        <td>{{ $p->nik }}</td>
                        <td>{{ $p->no_hp ?: '-' }}</td>
                        <td>{{ $p->desa ?: '-' }}</td>
                        <td><span class="b ok">{{ $p->kebun_count }} kebun</span></td>
                        <td>
                            @if($p->user)
                                {{ $p->user->email }}
                            @else
                                <span class="b">Belum ada</span>
                            @endif
                        </td>
                        <td>
                            <div class="acts">
                                <a href="{{ route('petani.edit', $p) }}" class="btn sec sm">Ubah</a>
                                <form method="POST" action="{{ route('petani.destroy', $p) }}"
                                      onsubmit="return confirm('Hapus petani ini beserta semua kebunnya?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn danger sm">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="mu" style="text-align:center;padding:32px">
                            Belum ada data petani. Klik “+ Tambah Petani” untuk memulai.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{ $petani->links('vendor.pagination.sip') }}
</section>
@endsection
