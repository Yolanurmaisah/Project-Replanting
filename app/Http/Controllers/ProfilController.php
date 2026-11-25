<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfilController extends Controller
{
    public function edit(Request $request)
    {
        return view('profil.edit', ['pengguna' => $request->user()]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            // Nama petani dikelola admin lewat menu Data Petani
            'name' => $user->isAdmin() ? 'required|string|max:100' : 'nullable',
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id)],
            'foto' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'password_lama' => 'nullable|required_with:password|current_password',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->email = $data['email'];

        if ($user->isAdmin()) {
            $user->name = $data['name'];
        }

        if (! empty($data['password'])) {
            $user->password = $data['password'];
        }

        if ($request->hasFile('foto')) {
            if ($user->foto) {
                Storage::disk('public')->delete($user->foto);
            }
            $user->foto = $request->file('foto')->store('profil', 'public');
        }

        $user->save();

        return redirect()->route('profil.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    public function hapusFoto(Request $request)
    {
        $user = $request->user();

        if ($user->foto) {
            Storage::disk('public')->delete($user->foto);
            $user->update(['foto' => null]);
        }

        return back()->with('success', 'Foto profil dihapus.');
    }
}
