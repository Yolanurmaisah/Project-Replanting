@extends('layouts.admin.app')
@section('title', 'Panduan')

@section('content')
<div class="head">
    <div>
        <h1>Panduan Replanting</h1>
        <div class="mu">Isi panduan per tahap. Petani melihat panduan sesuai tahap kebunnya.</div>
    </div>
    <a href="{{ route('panduan.create') }}" class="btn">+ Tambah Panduan</a>
</div>

@foreach($daftarTahap as $t)
    <section class="card">
        <div class="sec-head">
            <h2>{{ $t->urutan }}. {{ $t->nama_tahap }}</h2>
            <a href="{{ route('panduan.create', ['tahapan_id' => $t->id]) }}" class="btn sec sm">+ Tambah di tahap ini</a>
        </div>

        @forelse($t->panduan as $p)
            <div class="row-item">
                <div class="txt">
                    <b>{{ $p->judul }}</b>
                    <div class="mu">{{ \Illuminate\Support\Str::limit(str_replace("\n", ' ', $p->isi), 110) }}</div>
                    <div class="hint">Sumber: {{ $p->sumber }}</div>
                </div>
                <div class="acts">
                    <a href="{{ route('panduan.edit', $p) }}" class="btn sec sm">Ubah</a>
                    <form method="POST" action="{{ route('panduan.destroy', $p) }}"
                          onsubmit="return confirm('Hapus panduan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn danger sm">Hapus</button>
                    </form>
                </div>
            </div>
        @empty
            <div class="mu" style="padding:12px 0">Belum ada panduan untuk tahap ini.</div>
        @endforelse
    </section>
@endforeach
@endsection
