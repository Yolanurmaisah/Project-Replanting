@extends('layouts.admin.app')
@section('title', 'Pengguna')

@section('content')
<div class="head">
    <div>
        <h1>Data Pengguna</h1>
        <div class="mu">Kelola akun admin dan petani yang dapat masuk ke sistem</div>
    </div>
    <a href="{{ route('pengguna.create') }}" class="btn">+ Tambah Pengguna</a>
</div>

<section class="card">
    <div class="sc">
        <table>
            <thead>
                <tr><th>Nama</th><th>Email</th><th>Peran</th><th>Terhubung ke Petani</th><th></th></tr>
            </thead>
            <tbody>
                @foreach($pengguna as $u)
                    <tr>
                        <td>
                            <b>{{ $u->name }}</b>
                            @if($u->id === auth()->id())<span class="b ok">Akun saya</span>@endif
                        </td>
                        <td>{{ $u->email }}</td>
                        <td><span class="b {{ $u->isAdmin() ? 'ok' : '' }}">{{ $u->isAdmin() ? 'Admin' : 'Petani' }}</span></td>
                        <td>{{ $u->petani?->nama ?? '-' }}</td>
                        <td>
                            <div class="acts">
                                <a href="{{ route('pengguna.edit', $u) }}" class="btn sec sm">Ubah</a>
                                @if($u->id !== auth()->id())
                                    <form method="POST" action="{{ route('pengguna.destroy', $u) }}"
                                          onsubmit="return confirm('Hapus pengguna ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn danger sm">Hapus</button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $pengguna->links('vendor.pagination.sip') }}
</section>
@endsection
