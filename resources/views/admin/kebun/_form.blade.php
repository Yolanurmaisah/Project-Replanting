{{-- Form dipakai bersama oleh create.blade.php dan edit.blade.php --}}
<form method="POST" action="{{ $kebun->exists ? route('kebun.update', $kebun) : route('kebun.store') }}" class="card" style="max-width:760px">
    @csrf
    @if($kebun->exists)
        @method('PUT')
    @endif

    <div class="row2">
        <div class="fld">
            <label for="petani_id">Pemilik (petani)</label>
            <select class="inp" id="petani_id" name="petani_id" required>
                <option value="">-- pilih petani --</option>
                @foreach($daftarPetani as $p)
                    <option value="{{ $p->id }}" @selected(old('petani_id', $kebun->petani_id) == $p->id)>{{ $p->nama }} ({{ $p->nik }})</option>
                @endforeach
            </select>
            @if($daftarPetani->isEmpty())
                <span class="hint">Belum ada petani. Tambahkan dulu di menu Data Petani.</span>
            @endif
        </div>
        <div class="fld">
            <label for="nama_kebun">Nama / penanda kebun</label>
            <input class="inp" id="nama_kebun" name="nama_kebun" value="{{ old('nama_kebun', $kebun->nama_kebun) }}" required>
        </div>
        <div class="fld">
            <label for="lokasi">Lokasi</label>
            <input class="inp" id="lokasi" name="lokasi" value="{{ old('lokasi', $kebun->lokasi) }}" required>
        </div>
        <div class="fld">
            <label for="luas_ha">Luas (hektare)</label>
            <input class="inp" type="number" step="0.01" min="0.01" id="luas_ha" name="luas_ha" value="{{ old('luas_ha', $kebun->luas_ha) }}" required>
        </div>
        <div class="fld">
            <label for="tahun_tanam">Tahun tanam</label>
            <input class="inp" type="number" min="1980" max="{{ now()->year }}" id="tahun_tanam" name="tahun_tanam" value="{{ old('tahun_tanam', $kebun->tahun_tanam) }}" required>
            <span class="hint">Umur dan status kebun dihitung otomatis dari tahun ini.</span>
        </div>
        <div class="fld">
            <label for="tanggal_tanam_ulang">Tanggal tanam ulang <span class="mu" style="font-weight:400">(opsional)</span></label>
            <input class="inp" type="date" id="tanggal_tanam_ulang" name="tanggal_tanam_ulang" value="{{ old('tanggal_tanam_ulang', $kebun->tanggal_tanam_ulang?->toDateString()) }}">
            <span class="hint">Isi hanya jika kebun sudah ditanam ulang.</span>
        </div>

        @unless($kebun->exists)
            <div class="fld">
                <label for="tahapan_id">Tahap awal</label>
                <select class="inp" id="tahapan_id" name="tahapan_id" required>
                    @foreach($daftarTahap as $t)
                        <option value="{{ $t->id }}" @selected(old('tahapan_id', $kebun->tahapan_id) == $t->id)>{{ $t->urutan }}. {{ $t->nama_tahap }}</option>
                    @endforeach
                </select>
            </div>
        @endunless
    </div>

    <div class="acts" style="justify-content:flex-start;margin-top:8px">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ $kebun->exists ? route('kebun.show', $kebun) : route('kebun.index') }}" class="btn sec">Batal</a>
    </div>
</form>
