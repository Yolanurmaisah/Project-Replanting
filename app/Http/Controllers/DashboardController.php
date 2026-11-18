<?php

namespace App\Http\Controllers;

use App\Models\Kebun;
use App\Models\Pengaturan;
use App\Models\Petani;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            $kebun = Kebun::with(['petani', 'tahapan'])->get();

            $perStatus = ['normal' => 0, 'mendekati' => 0, 'siap' => 0];
            foreach ($kebun as $k) {
                $perStatus[$k->status_umur]++;
            }

            $siap = $kebun->filter(fn ($k) => $k->status_umur === 'siap')->sortByDesc('umur');
            $jumlahPetani = Petani::count();

            $batas = [
                'mendekati' => (int) Pengaturan::ambil('batas_mendekati', 22),
                'siap' => (int) Pengaturan::ambil('batas_siap', 25),
            ];
            $rentang = $this->rentangUmur($kebun, $batas);

            return view('dashboard.admin', compact('kebun', 'perStatus', 'siap', 'jumlahPetani', 'batas', 'rentang'));
        }

        $kebun = $user->petani
            ? $user->petani->kebun()->with('tahapan')->get()
            : collect();

        return view('dashboard.petani', compact('kebun'));
    }

    /** Kelompokkan kebun berdasarkan umur; batas atas mengikuti menu Pengaturan. */
    private function rentangUmur($kebun, array $batas): array
    {
        $m = $batas['mendekati'];
        $s = $batas['siap'];

        $daftar = [
            ['label' => '0–3 th (TBM)', 'min' => 0, 'max' => 3],
            ['label' => '4–10 th', 'min' => 4, 'max' => 10],
            ['label' => '11–'.($m - 1).' th', 'min' => 11, 'max' => $m - 1],
            ['label' => $m.'–'.($s - 1).' th', 'min' => $m, 'max' => $s - 1],
            ['label' => $s.'+ th', 'min' => $s, 'max' => PHP_INT_MAX],
        ];

        $labels = [];
        $data = [];
        foreach ($daftar as $r) {
            $labels[] = $r['label'];
            $data[] = $kebun->filter(fn ($k) => $k->umur >= $r['min'] && $k->umur <= $r['max'])->count();
        }

        return ['labels' => $labels, 'data' => $data];
    }
}
