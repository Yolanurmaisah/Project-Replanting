<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Panduan extends Model
{
    protected $table = 'panduan';

    protected $fillable = ['tahapan_id', 'judul', 'isi', 'sumber', 'urutan'];

    public function tahapan(): BelongsTo
    {
        return $this->belongsTo(Tahapan::class);
    }
}
