<?php

namespace App\Console\Commands;

use App\Models\Kebun;
use App\Models\Notifikasi;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CekStatusKebun extends Command
{
    protected $signature = 'replanting:cek';

    protected $description = 'Cek umur seluruh kebun dan buat notifikasi untuk kebun yang mendekati / siap replanting';

    public function handle(): int
    {
        $admin = User::where('role', 'admin')->get();
        $dibuat = 0;

        foreach (Kebun::with('petani.user')->get() as $kebun) {
            $status = $kebun->status_umur;
            if ($status === 'normal') {
                continue;
            }

            $penerima = $admin->concat($kebun->petani->user ? [$kebun->petani->user] : []);
            $judul = $status === 'siap' ? 'Kebun siap replanting' : 'Kebun mendekati masa replanting';
            $pesan = "Kebun {$kebun->nama_kebun} milik {$kebun->petani->nama} berumur {$kebun->umur} tahun ("
                .strtolower($kebun->status_label).').';

            foreach ($penerima as $user) {
                // Satu notifikasi per kebun, per penerima, per jenis (tidak dobel setiap hari)
                $sudahAda = Notifikasi::where('user_id', $user->id)
                    ->where('kebun_id', $kebun->id)
                    ->where('jenis', $status)
                    ->exists();
                if ($sudahAda) {
                    continue;
                }

                Notifikasi::kirim($user, $kebun, $judul, $pesan, $status);
                $dibuat++;

                try {
                    Mail::raw($pesan, fn ($m) => $m->to($user->email)->subject($judul));
                } catch (\Throwable $e) {
                    $this->warn("Email ke {$user->email} gagal: ".$e->getMessage());
                }
            }
        }

        $this->info("Selesai. {$dibuat} notifikasi baru dibuat.");

        return self::SUCCESS;
    }
}
