<?php

namespace Database\Seeders;

use App\Models\Panduan;
use App\Models\Tahapan;
use Illuminate\Database\Seeder;

/**
 * CATATAN: isi panduan di bawah masih berupa kerangka umum TANPA angka dosis.
 * Lengkapi dan verifikasi dengan pedoman resmi (BPDP, Kementan, PPKS)
 * lewat menu "Kelola Panduan", lalu isi kolom sumber dengan rujukan sebenarnya.
 */
class PanduanSeeder extends Seeder
{
    public function run(): void
    {
        $sumber = 'Kerangka awal - verifikasi dengan Permentan No. 03 Tahun 2022 / pedoman PPKS / BPDP';

        $isi = [
            1 => ['Pantau umur dan siapkan administrasi', "Catat tahun tanam kebun dan pantau status umurnya di sistem ini.\nSiapkan dokumen pribadi dan bukti legalitas lahan.\nPeriksa persyaratan PSR terbaru langsung di BPDP / dinas perkebunan setempat."],
            2 => ['Mengajukan peremajaan', "Pengajuan umumnya dilakukan melalui kelompok tani atau koperasi.\nLengkapi dokumen sesuai persyaratan terbaru BPDP.\nPastikan data luas dan lokasi kebun sama dengan dokumen pengajuan."],
            3 => ['Penumbangan tanaman lama', "Lakukan penumbangan setelah ada kepastian pengajuan.\nPerhatikan keselamatan kerja saat penumbangan.\nDokumentasikan kegiatan (foto) dan catat di riwayat tahap."],
            4 => ['Persiapan lahan', "Bersihkan lahan dari sisa tanaman lama.\nLakukan pengajiran dan pembuatan lubang tanam sesuai pedoman jarak tanam.\nAtur drainase lahan."],
            5 => ['Penanaman bibit', "Gunakan bibit bersertifikat dari sumber benih resmi.\nTanam sesuai jarak tanam yang dianjurkan pedoman.\nTanam tanaman penutup tanah (kacangan)."],
            6 => ['Pemeliharaan tanaman belum menghasilkan (TBM)', "Lakukan penyiangan dan perawatan tanaman muda secara rutin.\nPemupukan: ikuti jadwal dan dosis resmi dari pedoman (admin mengisi angka sesuai sumber).\nPantau hama dan penyakit, serta catat kondisi tanaman."],
        ];

        foreach ($isi as $urutan => [$judul, $teks]) {
            $tahapan = Tahapan::where('urutan', $urutan)->first();
            Panduan::updateOrCreate(
                ['tahapan_id' => $tahapan->id, 'judul' => $judul],
                ['isi' => $teks, 'sumber' => $sumber, 'urutan' => 1]
            );
        }
    }
}
