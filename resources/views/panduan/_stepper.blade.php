{{-- Variabel: $daftarTahap, $aktif (array id tahap), $jangkar (opsional: true = tiap tahap menjadi tautan ke bagiannya) --}}
@php
    $aktif = (array) ($aktif ?? []);
    $jangkar = $jangkar ?? false;
    $tunggal = count($aktif) === 1;
    $urutanAktif = $tunggal ? optional($daftarTahap->firstWhere('id', $aktif[0]))->urutan : null;
@endphp
<ol class="stepper" style="--n: {{ $daftarTahap->count() }}">
    @foreach($daftarTahap as $t)
        @php
            $kelas = in_array($t->id, $aktif) ? 'on' : (($urutanAktif && $t->urutan < $urutanAktif) ? 'done' : '');
        @endphp
        <li class="{{ $kelas }}">
            @if($jangkar)<a href="#tahap-{{ $t->id }}">@endif
                <span class="no">{{ $kelas === 'done' ? '✓' : $t->urutan }}</span>
                <span class="nm">{{ $t->nama_tahap }}</span>
            @if($jangkar)</a>@endif
        </li>
    @endforeach
</ol>
