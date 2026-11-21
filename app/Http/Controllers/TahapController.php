<?php

namespace App\Http\Controllers;

use App\Models\Kebun;
use App\Models\Notifikasi;
use App\Models\RiwayatTahap;
use App\Models\Tahapan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TahapController extends Controller
{
    public function edit(Kebun $kebun)
    {
        $kebun->load(['petani', 'tahapan']);
        $daftarTahap = Tahapan::orderBy('urutan')->get();

        return view('admin.kebun.tahap', compact('kebun', 'daftarTahap'));
    }

    public function update(Request $request, Kebun $kebun)
    {
        $data = $request->validate([
            'tahapan_id' => 'required|exists:tahapan,id',
            'tanggal' => 'required|date',
            'catatan' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
            'tanggal_tanam_ulang' => 'nullable|date',
        ]);

        DB::transaction(function () use ($request, $kebun, $data) {
            $kebun->update([
                'tahapan_id' => $data['tahapan_id'],
                'tanggal_tanam_ulang' => $data['tanggal_tanam_ulang'] ?? $kebun->tanggal_tanam_ulang,
            ]);

            RiwayatTahap::create([
                'kebun_id' => $kebun->id,
                'tahapan_id' => $data['tahapan_id'],
                'user_id' => $request->user()->id,
                'tanggal' => $data['tanggal'],
                'catatan' => $data['catatan'] ?? null,
                'foto' => $request->file('foto')?->store('riwayat', 'public'),
            ]);

            $pemilik = $kebun->petani->user;
            if ($pemilik) {
                $tahap = Tahapan::find($data['tahapan_id']);
                Notifikasi::kirim(
                    $pemilik,
                    $kebun,
                    'Tahap replanting diperbarui',
                    "Kebun {$kebun->nama_kebun} kini berada pada tahap: {$tahap->nama_tahap}.",
                    'tahap'
                );
            }
        });

        return redirect()->route('kebun.show', $kebun)->with('success', 'Tahap replanting diperbarui dan riwayat tercatat.');
    }
}
