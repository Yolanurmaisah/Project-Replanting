@extends('layouts.admin.app')
@section('title', 'Panduan Replanting')

@section('content')
<div class="head">
    <div>
        <h1>Panduan Replanting</h1>
        <div class="mu">Langkah demi langkah menanam ulang kebun sawit, dirangkum dari rujukan resmi</div>
    </div>
</div>

<section class="hero" style="min-height:0">
    <b class="sp"></b>
    <div>
        <span class="tag">Rujukan resmi</span>
        <h3>Disusun dari BPDP, Kementerian Pertanian, dan pedoman budidaya sawit</h3>
    </div>
    <p style="margin:14px 0 0;max-width:560px;opacity:.9">
        Setiap panduan mencantumkan sumber dan tautan ke dokumen aslinya. Untuk dosis pupuk dan hal teknis lain,
        selalu cocokkan dengan pedoman terbaru dan tanyakan ke penyuluh atau Dinas Perkebunan.
    </p>
</section>

<section class="card">
    <h2 style="margin-bottom:16px">Enam tahap replanting</h2>
    @include('panduan._stepper', ['daftarTahap' => $daftarTahap, 'aktif' => $tahapKebun, 'jangkar' => true])
    @if(count($tahapKebun))
        <p class="hint" style="margin:14px 0 0">Lingkaran hijau muda menandai tahap kebun Anda saat ini.</p>
    @endif
</section>

@foreach($daftarTahap as $t)
    <section class="card sect" id="tahap-{{ $t->id }}">
        <div class="tahap-head">
            <div class="no">{{ $t->urutan }}</div>
            <div>
                <h2>{{ $t->nama_tahap }}</h2>
                @if($t->deskripsi)<div class="mu">{{ $t->deskripsi }}</div>@endif
            </div>
            @if(in_array($t->id, $tahapKebun))
                <span class="b ok" style="margin-left:auto">Tahap kebun Anda</span>
            @endif
        </div>

        @include('panduan._kartu', ['panduan' => $t->panduan])
    </section>
@endforeach

<section class="card">
    <h2 style="margin-bottom:10px">Daftar rujukan</h2>
    @if($rujukan->isEmpty())
        <div class="mu">Belum ada rujukan bertautan.</div>
    @else
        <ol class="reflist">
            @foreach($rujukan as $r)
                <li>
                    <a href="{{ $r->tautan }}" target="_blank" rel="noopener noreferrer">{{ $r->sumber }}</a>
                </li>
            @endforeach
        </ol>
    @endif
    <p class="hint" style="margin:14px 0 0">
        Panduan ini ringkasan untuk membantu pekebun, bukan pengganti peraturan. Peraturan dan persyaratan dapat berubah,
        jadi konfirmasi ke Dinas Perkebunan kabupaten Anda sebelum bertindak.
    </p>
</section>
@endsection
