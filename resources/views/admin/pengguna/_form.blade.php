{{-- Form dipakai bersama oleh create.blade.php dan edit.blade.php --}}
<form method="POST" action="{{ $pengguna->exists ? route('pengguna.update', $pengguna) : route('pengguna.store') }}" class="card" style="max-width:760px">
    @csrf
    @if($pengguna->exists)
        @method('PUT')
    @endif

    <div class="row2">
        <div class="fld">
            <label for="name">Nama</label>
            <input class="inp" id="name" name="name" value="{{ old('name', $pengguna->name) }}" required>
        </div>
        <div class="fld">
            <label for="email">Email</label>
            <input class="inp" type="email" id="email" name="email" value="{{ old('email', $pengguna->email) }}" required>
        </div>
        <div class="fld">
            <label for="password">Password</label>
            <input class="inp" type="password" id="password" name="password" autocomplete="new-password" {{ $pengguna->exists ? '' : 'required' }}>
            @if($pengguna->exists)
                <span class="hint">Kosongkan jika tidak ingin mengubah password.</span>
            @else
                <span class="hint">Minimal 6 karakter.</span>
            @endif
        </div>
        <div class="fld">
            <label for="role">Peran</label>
            <select class="inp" id="role" name="role">
                <option value="admin" @selected(old('role', $pengguna->role) === 'admin')>Admin / Pengurus</option>
                <option value="petani" @selected(old('role', $pengguna->role) === 'petani')>Petani</option>
            </select>
            <span class="hint">Akun petani sebaiknya dibuat lewat menu Data Petani agar otomatis terhubung ke data petani.</span>
        </div>
    </div>

    <div class="acts" style="justify-content:flex-start;margin-top:8px">
        <button type="submit" class="btn">Simpan</button>
        <a href="{{ route('pengguna.index') }}" class="btn sec">Batal</a>
    </div>
</form>
