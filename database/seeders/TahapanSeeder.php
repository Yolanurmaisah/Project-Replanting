<?php

namespace Database\Seeders;

use App\Models\Tahapan;
use Illuminate\Database\Seeder;

class TahapanSeeder extends Seeder
{
    public function run(): void
    {
        $tahap = [
            [1, 'Belum Replanting', 'Kebun masih berproduksi. Pantau umur dan siapkan administrasi.'],
            [2, 'Pengajuan', 'Pengajuan peremajaan melalui kelompok tani/koperasi.'],
            [3, 'Penumbangan', 'Penumbangan tanaman lama.'],
            [4, 'Persiapan Lahan', 'Pembersihan lahan, pengajiran, dan pembuatan lubang tanam.'],
            [5, 'Penanaman', 'Penanaman bibit bersertifikat dan penutup tanah.'],
            [6, 'Pemeliharaan TBM', 'Perawatan tanaman belum menghasilkan.'],
        ];

        foreach ($tahap as [$urutan, $nama, $deskripsi]) {
            Tahapan::updateOrCreate(['urutan' => $urutan], ['nama_tahap' => $nama, 'deskripsi' => $deskripsi]);
        }
    }
}
