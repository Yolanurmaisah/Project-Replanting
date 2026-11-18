<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Tahapan extends Model
{
    protected $table = 'tahapan';

    protected $fillable = ['urutan', 'nama_tahap', 'deskripsi'];

    public function kebun(): HasMany
    {
        return $this->hasMany(Kebun::class);
    }

    public function panduan(): HasMany
    {
        return $this->hasMany(Panduan::class)->orderBy('urutan');
    }
}
