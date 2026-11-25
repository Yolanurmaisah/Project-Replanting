@extends('layouts.admin.app')
@section('title', 'Laporan')

@section('content')
<div class="head">
    <div>
        <h1>Laporan Kebun Siap Replanting</h1>
        <div class="mu">Kebun dengan umur {{ $batasSiap }} tahun ke atas</div>
    </div>
    <button type="button" class="btn no-print" onclick="window.print()">Cetak Laporan</button>
</div>

<div class="print-only">
    <b>Sistem Informasi Pemantauan dan Panduan Replanting Kelapa Sawit</b><br>
    Dicetak pada {{ now()->format('d-m-Y H:i') }}
</div>

<section class="card">
    <div class="sc">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kebun</th>
                    <th>Pemilik</th>
                    <th>Desa / No. HP</th>
                    <th>Luas</th>
                    <th>Tahun Tanam</th>
                    <th>Umur</th>
                    <th>Tahap</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kebun as $k)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><b>{{ $k->nama_kebun }}</b></td>
                        <td>{{ $k->petani->nama }}</td>
                        <td>{{ $k->petani->desa ?: '-' }} / {{ $k->petani->no_hp ?: '-' }}</td>
                        <td>{{ number_format($k->luas_ha, 2, ',', '.') }} ha</td>
                        <td>{{ $k->tahun_tanam }}</td>
                        <td>{{ $k->umur }} th</td>
                        <td>{{ $k->tahapan->nama_tahap }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="mu" style="text-align:center;padding:32px">Tidak ada kebun berstatus Siap Replanting.</td>
                    </tr>
                @endforelse
            </tbody>
            @if($kebun->count())
                <tfoot>
                    <tr>
                        <th colspan="4" style="text-align:right">Total</th>
                        <th>{{ number_format($kebun->sum('luas_ha'), 2, ',', '.') }} ha</th>
                        <th colspan="3">{{ $kebun->count() }} kebun</th>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</section>
@endsection
