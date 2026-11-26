<?php

namespace Database\Seeders;

use App\Models\Panduan;
use App\Models\Tahapan;
use Illuminate\Database\Seeder;

/**
 * Isi panduan dirangkum (bukan disalin) dari rujukan resmi dan tiap kartu mencantumkan tautannya.
 * Satu baris pada daftar poin = satu butir yang tampil bercentang.
 *
 * Angka dosis pupuk SENGAJA tidak dituliskan: sumber-sumber yang ditemukan memberi angka berbeda
 * menurut jenis tanah dan jenis pupuk. Petani diarahkan ke tabel resmi lewat tautan.
 *
 * Jalankan:  php artisan db:seed --class=PanduanSeeder
 */
class PanduanSeeder extends Seeder
{
    public function run(): void
    {
        // Hapus kerangka awal buatan seeder lama. Panduan yang Anda tambah sendiri tidak disentuh.
        Panduan::where('sumber', 'like', 'Kerangka awal%')->delete();

        foreach ($this->data() as $urutanTahap => $daftar) {
            $tahapan = Tahapan::where('urutan', $urutanTahap)->first();
            if (! $tahapan) {
                continue;
            }

            foreach ($daftar as $i => [$judul, $poin, $sumber, $tautan]) {
                Panduan::updateOrCreate(
                    ['tahapan_id' => $tahapan->id, 'judul' => $judul],
                    ['isi' => implode("\n", $poin), 'sumber' => $sumber, 'tautan' => $tautan, 'urutan' => $i + 1]
                );
            }
        }
    }

    private function data(): array
    {
        $bpdp = 'https://psr-bpdp.kemenkeu.go.id/persyaratan_pengajuan';
        $permentan3 = 'https://peraturan.bpk.go.id/Home/Details/224716/permentan-no-3-tahun-2022';
        $gapkiPsr = 'https://gapki.id/id/wikisawit/knowledge-base/peremajaan-sawit-rakyat-psr/';
        $gapkiReplanting = 'https://gapki.id/id/wikisawit/knowledge-base/replanting-dan-peremajaan-tanaman-kelapa-sawit/';
        $cybexLahan = 'http://cybex.pertanian.go.id/artikel/55192/pembukaan-lahan-pada-areal-peremajaan-kebun-kelapa-sawit/';
        $cybexLubang = 'http://cybex.pertanian.go.id/mobile/artikel/83390/TEKNIK-PEMANCANGAN-DAN-PEMBUATAN-LOBANG-TANAM-KELAPA-SAWIT-YANG-DIANJURKAN/';
        $gambut = 'https://www.bpdp.or.id/uploads/files/Permentan-14-09.pdf';
        $polbangtan = 'https://www.polbangtanmedan.ac.id/upload/upload/ebook/PETUNJUK%20PRAKTIKUM%20BUDIDAYA%20TANAMAN%20KELAPA%20SAWIT.pdf';
        $bmp = 'https://www.ppbri.or.id/11/Best%20Management%20Practices%20TBM%20TM-EL-2021.pdf';
        $spks = 'https://api.spks.or.id/storage/files/9__SOP_PEMUPUKAN_Fixed-edit1.pdf';

        return [
            // 1. Belum Replanting
            1 => [
                [
                    'Kapan kebun perlu diremajakan',
                    [
                        'Kebun umumnya diremajakan setelah melewati umur ekonomis sekitar 25 tahun.',
                        'Kriteria lain: produktivitas rendah (10 ton TBS per hektare per tahun atau kurang, pada tanaman berumur minimal 7 tahun) dan/atau kebun masih memakai benih yang tidak unggul.',
                        'Pemenuhan kriteria ini dibuktikan dengan surat pernyataan dari kelompok tani, gapoktan, koperasi, atau kelembagaan pekebun lainnya.',
                        'Pantau umur kebun di ReSawit. Saat statusnya Mendekati Replanting, mulailah menyiapkan berkas.',
                    ],
                    'Permentan No. 3 Tahun 2022 (penjelasan Dirjen Perkebunan, dimuat CNN Indonesia, 2023)',
                    $permentan3,
                ],
                [
                    'Siapkan keanggotaan dan legalitas lahan',
                    [
                        'Bergabunglah dengan kelompok tani, gapoktan, atau koperasi, karena pengajuan PSR dilakukan lewat kelembagaan pekebun.',
                        'Siapkan bukti legalitas lahan: sertifikat hak milik (SHM), atau surat pernyataan penguasaan fisik bidang tanah / dasar penguasaan lain yang sah.',
                        'Pastikan lahan tidak berada di kawasan hutan dan tidak berada di lahan HGU. Surat keterangan status lahan akan diminta.',
                        'Siapkan KTP elektronik dan kartu keluarga (KK) terbaru.',
                    ],
                    'BPDP - Persyaratan Pengajuan PSR',
                    $bpdp,
                ],
            ],

            // 2. Pengajuan
            2 => [
                [
                    'Dokumen yang disiapkan',
                    [
                        'Dari kelembagaan: profil lahan, profil pekebun, rancangan kerja dan RAB, akta pendirian atau perubahan, struktur organisasi, serta peta usulan lokasi berkoordinat.',
                        'Perjanjian: surat perjanjian kerja sama kemitraan dan surat perjanjian kerja sama kerja.',
                        'Surat pernyataan: memakai teknik tumbang serempak, melaksanakan peremajaan, rencana membeli benih unggul bersertifikat, serta umur tanaman / produktivitas / penggunaan benih tidak unggul.',
                        'Surat keterangan status lahan: bukan kawasan hutan dan bukan lahan HGU.',
                        'Dari pekebun: scan KTP elektronik, KK terbaru, dan surat kuasa pekebun asli. Dari lahan: bukti legalitas lahan.',
                        'Daftar ini bisa berubah. Cocokkan selalu dengan halaman resmi BPDP sebelum mengajukan.',
                    ],
                    'BPDP - Persyaratan Pengajuan PSR',
                    $bpdp,
                ],
                [
                    'Alur pengajuan PSR',
                    [
                        'Usulan diajukan oleh kelembagaan pekebun untuk anggotanya. Bantuan hibah diberikan kepada pekebun rakyat.',
                        'Jalur dinas kabupaten/kota: usulan ke kepala dinas, verifikasi dokumen dan lapangan, penetapan CP/CL (calon petani dan calon lahan) oleh bupati/wali kota, lalu rekomendasi teknis dari Dirjen Perkebunan ke BPDP.',
                        'Jalur kemitraan: kelembagaan pekebun bekerja sama dengan perusahaan perkebunan dan mengajukan ke Dirjen Perkebunan. Verifikasi dilakukan surveyor yang ditunjuk BPDP.',
                        'Tanyakan ke Dinas Perkebunan kabupaten Anda jalur mana yang tersedia dan kapan usulan dibuka.',
                    ],
                    'GAPKI WikiSawit - Peremajaan Sawit Rakyat (PSR)',
                    $gapkiPsr,
                ],
            ],

            // 3. Penumbangan
            3 => [
                [
                    'Penumbangan dan pencacahan tanaman lama',
                    [
                        'Buat rencana dan desain kebun lebih dulu: lingkup pekerjaan, ketersediaan mesin dan alat, waktu pelaksanaan, dan biaya.',
                        'Pembukaan lahan pada areal peremajaan dapat dilakukan secara manual yang dikombinasikan dengan mekanis, atau sepenuhnya mekanis.',
                        'Pohon lama ditebang lalu dicincang dengan kampak atau chainsaw, atau dengan excavator pada cara mekanis.',
                        'Pada cara mekanis, setelah batang dirumpuk, tanah dibajak dan digaru dengan traktor agar siap ditanami.',
                        'PSR mensyaratkan teknik tumbang serempak. Lihat tahap Pengajuan.',
                    ],
                    'Cybex Kementan - Pembukaan Lahan pada Areal Peremajaan Kebun Kelapa Sawit',
                    $cybexLahan,
                ],
                [
                    'Lakukan tanpa membakar',
                    [
                        'Bongkar tanaman tua tanpa pembakaran. Pembakaran lahan dilarang.',
                        'Bersihkan sisa tebangan dan manfaatkan biomassanya dengan cara didaur ulang.',
                        'Siapkan drainase dan pematang sesuai kondisi lahan.',
                    ],
                    'GAPKI WikiSawit - Replanting dan Peremajaan Tanaman Kelapa Sawit',
                    $gapkiReplanting,
                ],
            ],

            // 4. Persiapan Lahan
            4 => [
                [
                    'Pemancangan, jarak tanam, dan lubang tanam',
                    [
                        'Jarak tanam yang umum adalah segitiga sama sisi 9 m x 9 m x 9 m. Jarak antar-barisan arah utara-selatan sekitar 7,8 m dan populasinya sekitar 143 pohon per hektare.',
                        'Alternatifnya segitiga sama sisi 9,5 m dengan populasi sekitar 128 pohon per hektare.',
                        'Tancapkan ajir sesuai jarak tanam. Setelah lubang selesai digali, ajir dikembalikan ke tengah lubang.',
                        'Buat lubang tanam sebelum waktu tanam supaya tanah galian terkena pengaruh iklim. Sumber menyarankan antara seminggu sampai sebulan sebelumnya. Membuat lubang hanya 1-2 hari sebelum tanam tidak dianjurkan.',
                        'Pisahkan tanah lapisan atas dan tanah lapisan bawah saat menggali.',
                        'Ukuran lubang yang dianjurkan sumber ini 90 x 90 x 60 cm, sedangkan sumber lain memakai 60 x 60 x 60 cm. Ikuti anjuran penyuluh atau pelaksana sesuai kondisi tanah kebun Anda.',
                        'Pada lahan berbukit atau berkontur, lubang diletakkan paling dekat 1,5 m dari sisi lereng.',
                    ],
                    'Cybex Kementan - Teknik Pemancangan dan Pembuatan Lobang Tanam; Permentan 14/2009 (jumlah pohon per hektare)',
                    $cybexLubang,
                ],
                [
                    'Jika kebun berada di lahan gambut',
                    [
                        'Sawit di lahan gambut hanya boleh pada kawasan budidaya, misalnya areal penggunaan lain (APL) atau kawasan hutan yang sudah dilepas.',
                        'Penanaman memperhatikan daya dukung gambut. Kerapatannya 143 pohon per hektare (jarak 9 m segitiga sama sisi), atau menyesuaikan panjang tajuk varietas yang dipakai.',
                        'Jika jalur tanam dipadatkan, ukuran lubang tanam 60 x 60 x 60 cm.',
                        'Jika jalur tidak dipadatkan, pakai sistem lubang dalam lubang: lubang luar 100 x 100 x 60 cm dan lubang dalam 60 x 60 x 60 cm.',
                        'Banyak kebun di Riau berada di lahan gambut. Tanyakan ke penyuluh sebelum mengolah lahan gambut.',
                    ],
                    'Permentan No. 14/Permentan/PL.110/2/2009 tentang Pedoman Pemanfaatan Lahan Gambut untuk Budidaya Kelapa Sawit',
                    $gambut,
                ],
            ],

            // 5. Penanaman
            5 => [
                [
                    'Gunakan bibit unggul bersertifikat',
                    [
                        'PSR mensyaratkan surat ketersediaan atau rencana pembelian benih unggul bersertifikat. Rencanakan pembelian bibit sejak tahap pengajuan.',
                        'Tanyakan ke Dinas Perkebunan daftar penangkar atau penyedia bibit bersertifikat di daerah Anda.',
                        'Periksa dokumen sertifikat bibit sebelum membeli. Benih tidak unggul adalah salah satu alasan kebun perlu diremajakan.',
                    ],
                    'BPDP - Persyaratan Pengajuan PSR',
                    $bpdp,
                ],
                [
                    'Penanaman bibit dan penyisipan',
                    [
                        'Bibit di tempat pengumpulan sementara sebaiknya tidak disimpan lebih dari 24 jam sebelum ditanam.',
                        'Sebar bibit ke dekat lubang tanam sebelum ditanam, supaya penanaman cepat dan bibit tidak rusak.',
                        'Tanam tanaman penutup tanah (kacangan) sesuai petunjuk pelaksana atau penyuluh.',
                        'Tanaman yang mati diganti (disisip) dengan cara yang sama seperti penanaman biasa.',
                    ],
                    'Polbangtan Medan (Kementan) - Petunjuk Praktikum Budidaya Tanaman Kelapa Sawit',
                    $polbangtan,
                ],
            ],

            // 6. Pemeliharaan TBM
            6 => [
                [
                    'Pemeliharaan harian tanaman muda',
                    [
                        'Rawat piringan (area di sekeliling batang). Pada tanaman TBM 1 (di bawah 12 bulan), perawatan piringan sebaiknya dilakukan manual.',
                        'Jaga lahan di antara barisan tanaman tetap bebas dari lalang dan gulma berbahaya.',
                        'Ganti tanaman yang mati atau tumbuh tidak normal.',
                        'Catat kegiatan dan foto kondisi kebun di menu Update Tahap sebagai bukti dan riwayat.',
                    ],
                    'Polbangtan Medan (Kementan) - Petunjuk Praktikum Budidaya Tanaman Kelapa Sawit',
                    $polbangtan,
                ],
                [
                    'Pemupukan TBM: ikuti tabel resmi, jangan asal angka',
                    [
                        'Dosis pupuk TBM berbeda menurut umur tanaman, jenis tanah (mineral, gambut, berpasir), dan jenis pupuk (tunggal atau majemuk).',
                        'Angka dosis di berbagai situs internet berbeda-beda. Jangan memakai angka dari sembarang situs.',
                        'Gunakan tabel standar PPKS sesuai jenis tanah kebun Anda. Dokumen di tautan ini menyebut bahwa pemupukan TBM mengikuti standar PPKS berdasarkan umur tanaman.',
                        'Pupuk ditebar di piringan tanaman. Jenis yang umum: pupuk makro (urea, TSP, RP, MOP, dolomit) dan mikro (borat, Cu, Zn, Fe).',
                        'Konsultasikan jadwal dan dosis dengan penyuluh atau Dinas Perkebunan sebelum memupuk.',
                    ],
                    'Best Management Practices TBM dan TM Kelapa Sawit (rujukan standar pemupukan PPKS)',
                    $bmp,
                ],
                [
                    'SOP pemupukan untuk petani (jadwal per jenis tanah)',
                    [
                        'Dokumen ini disusun untuk petani kelapa sawit dan memuat jadwal pemupukan TBM yang terpisah untuk tanah mineral, tanah sangat berpasir, dan gambut.',
                        'Dosis dinyatakan dalam gram per pohon menurut bulan umur tanaman. Buka dokumennya untuk tabel lengkap.',
                        'Dokumen juga membahas penggunaan tandan kosong sawit (TKS) sebagai bahan organik pada TBM.',
                        'Dokumen ini disusun organisasi petani (SPKS), bukan lembaga pemerintah. Bandingkan dengan standar PPKS di atas.',
                    ],
                    'SPKS - SOP Agronomi: Manajemen Pemupukan',
                    $spks,
                ],
            ],
        ];
    }
}
