<?php

namespace App\Http\Controllers;

use App\Models\Panduan;
use App\Models\Tahapan;
use Illuminate\Http\Request;

class PanduanController extends Controller
{
    /** Halaman baca panduan untuk semua pengguna yang login. */
    public function lihat(Request $request)
    {
        $daftarTahap = Tahapan::with('panduan')->orderBy('urutan')->get();

        $user = $request->user();
        $tahapKebun = ($user->isAdmin() || ! $user->petani)
            ? []
            : $user->petani->kebun()->pluck('tahapan_id')->unique()->values()->all();

        $rujukan = $daftarTahap->flatMap(fn ($t) => $t->panduan)
            ->filter(fn ($p) => $p->tautan)
            ->unique('tautan')
            ->values();

        return view('panduan.lihat', compact('daftarTahap', 'tahapKebun', 'rujukan'));
    }

    // ---------- Kelola panduan (khusus admin) ----------

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
            'tautan' => 'nullable|url|max:500',
            'urutan' => 'required|integer|min:1',
        ];
    }
}
