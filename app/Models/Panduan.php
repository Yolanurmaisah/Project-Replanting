<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Panduan extends Model
{
    protected $table = 'panduan';

    protected $fillable = ['tahapan_id', 'judul', 'isi', 'sumber', 'tautan', 'urutan'];

    public function tahapan(): BelongsTo
    {
        return $this->belongsTo(Tahapan::class);
    }

    /** Isi panduan dipecah per baris menjadi daftar poin (satu baris = satu poin). */
    protected function poin(): Attribute
    {
        return Attribute::get(function () {
            return collect(preg_split('/\R/u', (string) $this->isi))
                ->map(fn ($baris) => trim(preg_replace('/^[-•*]\s*/u', '', trim($baris))))
                ->filter()
                ->values()
                ->all();
        });
    }
}
