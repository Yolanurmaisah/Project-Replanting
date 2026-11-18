<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RiwayatTahap extends Model
{
    protected $table = 'riwayat_tahap';

    protected $fillable = ['kebun_id', 'tahapan_id', 'user_id', 'tanggal', 'catatan', 'foto'];

    protected function casts(): array
    {
        return ['tanggal' => 'date'];
    }

    public function kebun(): BelongsTo
    {
        return $this->belongsTo(Kebun::class);
    }

    public function tahapan(): BelongsTo
    {
        return $this->belongsTo(Tahapan::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
