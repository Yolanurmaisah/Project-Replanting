<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\Request;

class PengaturanController extends Controller
{
    public function edit()
    {
        return view('pengaturan.edit', [
            'mendekati' => Pengaturan::ambil('batas_mendekati', 22),
            'siap' => Pengaturan::ambil('batas_siap', 25),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'batas_mendekati' => 'required|integer|min:1|max:60',
            'batas_siap' => 'required|integer|min:1|max:60|gt:batas_mendekati',
        ]);
        Pengaturan::simpan('batas_mendekati', $data['batas_mendekati']);
        Pengaturan::simpan('batas_siap', $data['batas_siap']);

        return back()->with('success', 'Pengaturan ambang umur disimpan.');
    }
}
