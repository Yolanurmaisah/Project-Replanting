<?php

namespace App\Http\Controllers;

use App\Models\Kebun;

class LaporanController extends Controller
{
    public function siapReplanting()
    {
        $kebun = Kebun::with(['petani', 'tahapan'])->get()
            ->filter(fn ($k) => $k->status_umur === 'siap')
            ->sortByDesc('umur')
            ->values();

        return view('laporan.siap', compact('kebun'));
    }
}
