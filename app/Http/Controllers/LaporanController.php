<?php

namespace App\Http\Controllers;

use App\Models\Kebun;
use App\Models\Pengaturan;

class LaporanController extends Controller
{
    public function siapReplanting()
    {
        $kebun = Kebun::with(['petani', 'tahapan'])->get()
            ->filter(fn ($k) => $k->status_umur === 'siap')
            ->sortByDesc('umur')
            ->values();

        $batasSiap = (int) Pengaturan::ambil('batas_siap', 25);

        return view('admin.laporan.siap', compact('kebun', 'batasSiap'));
    }
}
