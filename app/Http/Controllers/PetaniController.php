<?php

namespace App\Http\Controllers;

use App\Models\Petani;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PetaniController extends Controller
{
    public function index()
    {
        $petani = Petani::with('user')->withCount('kebun')->orderBy('nama')->paginate(10);

        return view('petani.index', compact('petani'));
    }

    public function create()
    {
        return view('petani.form', ['petani' => new Petani]);
    }

    public function store(Request $request)
    {
        $request->validate($this->rules());

        DB::transaction(function () use ($request) {
            $petani = Petani::create($request->only('nama', 'nik', 'no_hp', 'alamat', 'desa'));
            $this->simpanAkun($request, $petani);
        });

        return redirect()->route('petani.index')->with('success', 'Data petani ditambahkan.');
    }

    public function edit(Petani $petani)
    {
        return view('petani.form', compact('petani'));
    }

    public function update(Request $request, Petani $petani)
    {
        $request->validate($this->rules($petani));

        DB::transaction(function () use ($request, $petani) {
            $petani->update($request->only('nama', 'nik', 'no_hp', 'alamat', 'desa'));
            $this->simpanAkun($request, $petani);
        });

        return redirect()->route('petani.index')->with('success', 'Data petani diperbarui.');
    }

    public function destroy(Petani $petani)
    {
        $user = $petani->user;
        $petani->delete(); // kebun & riwayatnya ikut terhapus (cascade)
        $user?->delete();

        return redirect()->route('petani.index')->with('success', 'Data petani dihapus.');
    }

    private function rules(?Petani $petani = null): array
    {
        return [
            'nama' => 'required|string|max:100',
            'nik' => ['required', 'digits:16', Rule::unique('petani', 'nik')->ignore($petani?->id)],
            'no_hp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string',
            'desa' => 'nullable|string|max:100',
            'email' => ['nullable', 'email', 'max:100', Rule::unique('users', 'email')->ignore($petani?->user_id)],
            'password' => [Rule::requiredIf(fn () => request()->filled('email') && ! $petani?->user), 'nullable', 'string', 'min:6'],
        ];
    }

    /** Buat atau perbarui akun login petani (opsional, diisi lewat email). */
    private function simpanAkun(Request $request, Petani $petani): void
    {
        if (! $request->filled('email')) {
            return;
        }

        if ($petani->user) {
            $petani->user->fill(['name' => $petani->nama, 'email' => $request->email]);
            if ($request->filled('password')) {
                $petani->user->password = $request->password;
            }
            $petani->user->save();

            return;
        }

        $user = User::create([
            'name' => $petani->nama,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'petani',
        ]);
        $petani->update(['user_id' => $user->id]);
    }
}
