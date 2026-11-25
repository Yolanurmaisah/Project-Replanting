<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PenggunaController extends Controller
{
    public function index()
    {
        $pengguna = User::with('petani')->orderBy('name')->paginate(10);

        return view('admin.pengguna.index', compact('pengguna'));
    }

    public function create()
    {
        return view('admin.pengguna.create', ['pengguna' => new User(['role' => 'admin'])]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100|unique:users,email',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,petani',
        ]);

        User::create($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna ditambahkan.');
    }

    public function edit(User $pengguna)
    {
        return view('admin.pengguna.edit', compact('pengguna'));
    }

    public function update(Request $request, User $pengguna)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($pengguna->id)],
            'password' => 'nullable|string|min:6',
            'role' => 'required|in:admin,petani',
        ]);

        if ($pengguna->id === $request->user()->id && $data['role'] !== 'admin') {
            return back()->withInput()->withErrors(['role' => 'Anda tidak bisa mengubah peran akun Anda sendiri menjadi petani.']);
        }

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $pengguna->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna diperbarui.');
    }

    public function destroy(Request $request, User $pengguna)
    {
        if ($pengguna->id === $request->user()->id) {
            return back()->withErrors(['hapus' => 'Akun yang sedang dipakai tidak bisa dihapus.']);
        }

        $pengguna->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna dihapus.');
    }
}
