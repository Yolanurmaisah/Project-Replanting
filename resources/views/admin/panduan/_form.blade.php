{{-- Form dipakai bersama oleh create.blade.php dan edit.blade.php --}}
<form method="POST" action="{{ $panduan->exists ? route('panduan.update', $panduan) : route('panduan.store') }}" class="card" style="max-width:760px">
    @csrf
    @if($panduan->exists)
        @method('PUT')
    @endif

    <div class="row2">
        <div class="fld">
            <label for="tahapan_id">Tahap</label>
            <select class="inp" id="tahapan_id" name="tahapan_id" required>
                <option value="">-- pilih tahap --</option>
                @foreach($daftarTahap as $t)
                    <option value="{{ $t->id }}" @selected(old('tahapan_id', $panduan->tahapan_id) == $t->id)>{{ $t->urutan }}. {{ $t->nama_tahap }}</option>
                @endforeach
            </select>
        </div>
        <div class="fld">
            <label for="urutan">Urutan tampil</label>
            <input class="inp" type="number" min="1" id="urutan" name="urutan" value="{{ old('urutan', $panduan->urutan) }}" required>
            <span class="hint">Angka kecil tampil lebih dulu dalam satu tahap.</span>
        </div>
    </div>

    <div class="fld">
        <label for="judul">Judul panduan</label>
        <input class="inp" id="judul" name="judul" value="{{ old('judul', $panduan->judul) }}" required>
    </div>

    <div class="fld">
        <label for="isi">Isi panduan</label>
        <textarea class="inp" id="isi" name="isi" style="min-height:220px" required>{{ old('isi', $panduan->isi) }}</textarea>
        <span class="hint">Tulis satu poin per baris. Tiap baris akan tampil sebagai butir bercentang.</span>
    </div>

    <div class="row2">
        <div class="fld">
            <label for="sumber">Sumber rujukan resmi</label>
            <input class="inp" id="sumber" name="sumber" value="{{ old('sumber', $panduan->sumber) }}" required>
            <span class="hint">Wajib. Contoh: Permentan No. 3 Tahun 2022.</span>
        </div>
        <div class="fld">
            <label for="tautan">Tautan ke dokumen sumber <span class="mu" style="font-weight:400">(opsional)</span></label>
            <input class="inp" type="url" id="tautan" name="tautan" value="{{ old('tautan', $panduan->tautan) }}" placeholder="https://...">
            <span class="hint">Alamat lengkap diawali https://. Muncul sebagai tombol “Buka sumber”.</span>
        </div>
    </div>

    <div class="acts" style="justify-content:flex-start;margin-top:8px">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('panduan.index') }}" class="btn sec">Batal</a>
    </div>
</form>
