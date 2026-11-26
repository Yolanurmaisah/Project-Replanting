<?php

namespace App\Http\Controllers;

use App\Models\Kebun;
use App\Models\Panduan;
use App\Models\Petani;
use App\Models\RiwayatTahap;
use App\Models\Tahapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KebunController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $status = $request->query('status');

        $query = Kebun::with(['petani', 'tahapan']);
        if (! $user->isAdmin()) {
            $query->where('petani_id', $user->petani?->id ?? 0);
        }

        $kebun = $query->orderBy('nama_kebun')->get();

        if ($status) {
            $kebun = $kebun->filter(fn ($k) => $k->status_umur === $status)->values();
        }

        return $this->tampil('index', compact('kebun', 'status'));
    }

    public function show(Request $request, Kebun $kebun)
    {
        $user = $request->user();
        abort_unless($user->isAdmin() || $kebun->petani->user_id === $user->id, 403, 'Akses ditolak.');

        $kebun->load(['petani', 'tahapan']);
        $riwayat = $kebun->riwayat()->with(['tahapan', 'user'])->orderByDesc('tanggal')->orderByDesc('id')->get();
        $panduan = Panduan::where('tahapan_id', $kebun->tahapan_id)->orderBy('urutan')->get();

        $daftarTahap = Tahapan::orderBy('urutan')->get();

        return $this->tampil('show', compact('kebun', 'riwayat', 'panduan', 'daftarTahap'));
    }

    public function create()
    {
        $kebun = new Kebun(['tahapan_id' => Tahapan::orderBy('urutan')->value('id')]);

        return view('admin.kebun.create', ['kebun' => $kebun] + $this->pilihan());
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules() + ['tahapan_id' => 'required|exists:tahapan,id']);

        DB::transaction(function () use ($data, $request) {
            $kebun = Kebun::create($data);
            RiwayatTahap::create([
                'kebun_id' => $kebun->id,
                'tahapan_id' => $kebun->tahapan_id,
                'user_id' => $request->user()->id,
                'tanggal' => now()->toDateString(),
                'catatan' => 'Kebun didaftarkan ke sistem.',
            ]);
        });

        return redirect()->route('kebun.index')->with('success', 'Data kebun ditambahkan.');
    }

    public function edit(Kebun $kebun)
    {
        return view('admin.kebun.edit', compact('kebun') + $this->pilihan());
    }

    public function update(Request $request, Kebun $kebun)
    {
        $kebun->update($request->validate($this->rules()));

        return redirect()->route('kebun.show', $kebun)->with('success', 'Data kebun diperbarui.');
    }

    public function destroy(Kebun $kebun)
    {
        $kebun->delete();

        return redirect()->route('kebun.index')->with('success', 'Data kebun dihapus.');
    }

    /** Admin memakai view di admin/kebun, petani di petani/kebun (dibuat pada tahap dashboard petani). */
    private function tampil(string $nama, array $data)
    {
        $folder = auth()->user()->isAdmin() ? 'admin.kebun.' : 'petani.kebun.';

        return view($folder.$nama, $data);
    }

    private function rules(): array
    {
        return [
            'petani_id' => 'required|exists:petani,id',
            'nama_kebun' => 'required|string|max:100',
            'lokasi' => 'required|string|max:150',
            'luas_ha' => 'required|numeric|min:0.01|max:999999',
            'tahun_tanam' => 'required|integer|min:1980|max:'.now()->year,
            'tanggal_tanam_ulang' => 'nullable|date',
        ];
    }

    private function pilihan(): array
    {
        return [
            'daftarPetani' => Petani::orderBy('nama')->get(),
            'daftarTahap' => Tahapan::orderBy('urutan')->get(),
        ];
    }
}
