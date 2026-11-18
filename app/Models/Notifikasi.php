<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = ['user_id', 'kebun_id', 'judul', 'pesan', 'jenis', 'sudah_dibaca'];

    protected function casts(): array
    {
        return ['sudah_dibaca' => 'boolean'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kebun(): BelongsTo
    {
        return $this->belongsTo(Kebun::class);
    }

    public static function kirim(User $user, ?Kebun $kebun, string $judul, string $pesan, string $jenis): self
    {
        return static::create([
            'user_id' => $user->id,
            'kebun_id' => $kebun?->id,
            'judul' => $judul,
            'pesan' => $pesan,
            'jenis' => $jenis,
            'sudah_dibaca' => false,
        ]);
    }
}
