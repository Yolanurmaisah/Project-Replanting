{{-- Variabel: $panduan (koleksi Panduan untuk satu tahap) --}}
@forelse($panduan as $p)
    <article class="gcard">
        <h3>{{ $p->judul }}</h3>
        <ul class="checks">
            @foreach($p->poin as $butir)
                <li><span>{{ $butir }}</span></li>
            @endforeach
        </ul>
        <div class="gsrc">
            <span>Sumber: {{ $p->sumber }}</span>
            @if($p->tautan)
                <a class="lnk" href="{{ $p->tautan }}" target="_blank" rel="noopener noreferrer">Buka sumber &#8599;</a>
            @endif
        </div>
    </article>
@empty
    <div class="mu">Belum ada panduan untuk tahap ini.</div>
@endforelse
