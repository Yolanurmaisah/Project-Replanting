<?php

namespace App\Http\Controllers;

use App\Models\Panduan;
use App\Models\Tahapan;
use Illuminate\Http\Request;

class PanduanController extends Controller
{
    public function index()
    {
        $daftarTahap = Tahapan::with('panduan')->orderBy('urutan')->get();

        return view('admin.panduan.index', compact('daftarTahap'));
    }

    public function create(Request $request)
    {
        $panduan = new Panduan([
            'urutan' => 1,
            'tahapan_id' => $request->query('tahapan_id'),
        ]);

        return view('admin.panduan.create', [
            'panduan' => $panduan,
            'daftarTahap' => Tahapan::orderBy('urutan')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Panduan::create($request->validate($this->rules()));

        return redirect()->route('panduan.index')->with('success', 'Panduan ditambahkan.');
    }

    public function edit(Panduan $panduan)
    {
        return view('admin.panduan.edit', [
            'panduan' => $panduan,
            'daftarTahap' => Tahapan::orderBy('urutan')->get(),
        ]);
    }

    public function update(Request $request, Panduan $panduan)
    {
        $panduan->update($request->validate($this->rules()));

        return redirect()->route('panduan.index')->with('success', 'Panduan diperbarui.');
    }

    public function destroy(Panduan $panduan)
    {
        $panduan->delete();

        return redirect()->route('panduan.index')->with('success', 'Panduan dihapus.');
    }

    private function rules(): array
    {
        return [
            'tahapan_id' => 'required|exists:tahapan,id',
            'judul' => 'required|string|max:150',
            'isi' => 'required|string',
            'sumber' => 'required|string|max:255',
            'urutan' => 'required|integer|min:1',
        ];
    }
}
