<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'foto'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /** Alamat foto profil, atau null bila belum ada. */
    protected function fotoUrl(): Attribute
    {
        return Attribute::get(fn () => $this->foto ? asset('storage/'.$this->foto) : null);
    }

    /** Huruf awal nama (maks. 2) untuk avatar bila belum ada foto. */
    protected function inisial(): Attribute
    {
        return Attribute::get(fn () => Str::upper(
            collect(explode(' ', trim($this->name)))->filter()->take(2)->map(fn ($w) => mb_substr($w, 0, 1))->implode('')
        ));
    }

    public function petani(): HasOne
    {
        return $this->hasOne(Petani::class);
    }

    public function notifikasi(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }
}
