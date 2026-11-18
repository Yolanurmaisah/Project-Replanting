<?php

namespace Database\Seeders;

use App\Models\Kebun;
use App\Models\Pengaturan;
use App\Models\Petani;
use App\Models\RiwayatTahap;
use App\Models\Tahapan;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([TahapanSeeder::class, PanduanSeeder::class]);

        Pengaturan::simpan('batas_mendekati', 22);
        Pengaturan::simpan('batas_siap', 25);

        $admin = User::updateOrCreate(
            ['email' => 'admin@replanting.test'],
            ['name' => 'Admin Kelompok Tani', 'password' => 'password', 'role' => 'admin']
        );

        // ---- Data contoh (hapus bila tidak diperlukan) ----
        $tahunIni = now()->year;
        $contoh = [
            ['Budi Santoso', '1471010101800001', 'budi@replanting.test', 'Desa Sungai Pinang', [
                ['Kebun A', 2.0, $tahunIni - 26, 1],
                ['Kebun B', 1.5, $tahunIni - 23, 1],
            ]],
            ['Siti Aminah', '1471010202850002', 'siti@replanting.test', 'Desa Pangkalan Baru', [
                ['Kebun C', 2.0, $tahunIni - 10, 1],
                ['Kebun D', 1.0, $tahunIni - 25, 3],
            ]],
            ['Agus Salim', '1471010303900003', 'agus@replanting.test', 'Desa Kualu', [
                ['Kebun E', 3.0, $tahunIni - 5, 1],
            ]],
        ];

        foreach ($contoh as [$nama, $nik, $email, $desa, $daftarKebun]) {
            $user = User::updateOrCreate(
                ['email' => $email],
                ['name' => $nama, 'password' => 'password', 'role' => 'petani']
            );
            $petani = Petani::updateOrCreate(
                ['nik' => $nik],
                ['user_id' => $user->id, 'nama' => $nama, 'no_hp' => '08123456789', 'alamat' => $desa, 'desa' => $desa]
            );

            foreach ($daftarKebun as [$namaKebun, $luas, $tahun, $urutanTahap]) {
                $tahap = Tahapan::where('urutan', $urutanTahap)->first();
                $kebun = Kebun::firstOrCreate(
                    ['petani_id' => $petani->id, 'nama_kebun' => $namaKebun],
                    ['tahapan_id' => $tahap->id, 'lokasi' => $desa, 'luas_ha' => $luas, 'tahun_tanam' => $tahun]
                );
                if ($kebun->wasRecentlyCreated) {
                    RiwayatTahap::create([
                        'kebun_id' => $kebun->id, 'tahapan_id' => $tahap->id, 'user_id' => $admin->id,
                        'tanggal' => now()->toDateString(), 'catatan' => 'Data awal.',
                    ]);
                }
            }
        }
    }
}
