<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Petani extends Model
{
    protected $table = 'petani';

    protected $fillable = ['user_id', 'nik', 'nama', 'no_hp', 'alamat', 'desa'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kebun(): HasMany
    {
        return $this->hasMany(Kebun::class);
    }
}
