<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    protected $table = 'pengaturan';

    protected $fillable = ['kunci', 'nilai'];

    protected static array $cache = [];

    public static function ambil(string $kunci, $default = null)
    {
        return static::$cache[$kunci] ??= (static::where('kunci', $kunci)->value('nilai') ?? $default);
    }

    public static function simpan(string $kunci, $nilai): void
    {
        static::updateOrCreate(['kunci' => $kunci], ['nilai' => $nilai]);
        static::$cache = [];
    }
}
