<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kebun extends Model
{
    protected $table = 'kebun';

    protected $fillable = [
        'petani_id', 'tahapan_id', 'nama_kebun', 'lokasi',
        'luas_ha', 'tahun_tanam', 'tanggal_tanam_ulang',
    ];

    protected function casts(): array
    {
        return [
            'luas_ha' => 'decimal:2',
            'tanggal_tanam_ulang' => 'date',
        ];
    }

    /** status => [label, warna badge Bootstrap] */
    public const STATUS = [
        'normal' => ['Normal', 'success'],
        'mendekati' => ['Mendekati Replanting', 'warning'],
        'siap' => ['Siap Replanting', 'danger'],
    ];

    public function petani(): BelongsTo
    {
        return $this->belongsTo(Petani::class);
    }

    public function tahapan(): BelongsTo
    {
        return $this->belongsTo(Tahapan::class);
    }

    public function riwayat(): HasMany
    {
        return $this->hasMany(RiwayatTahap::class);
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }

    /**
     * Umur tidak disimpan di database, dihitung dari tahun tanam.
     * Jika kebun sudah ditanam ulang, umur dihitung dari tahun tanam ulang.
     */
    protected function umur(): Attribute
    {
        return Attribute::get(function () {
            $acuan = $this->tanggal_tanam_ulang?->year ?? (int) $this->tahun_tanam;

            return max(0, now()->year - $acuan);
        });
    }

    protected function statusUmur(): Attribute
    {
        return Attribute::get(function () {
            $siap = (int) Pengaturan::ambil('batas_siap', 25);
            $mendekati = (int) Pengaturan::ambil('batas_mendekati', 22);

            if ($this->umur >= $siap) {
                return 'siap';
            }

            return $this->umur >= $mendekati ? 'mendekati' : 'normal';
        });
    }

    protected function statusLabel(): Attribute
    {
        return Attribute::get(fn () => self::STATUS[$this->status_umur][0]);
    }

    protected function statusBadge(): Attribute
    {
        return Attribute::get(fn () => self::STATUS[$this->status_umur][1]);
    }
}
