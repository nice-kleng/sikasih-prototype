<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke IbuHamil
     */
    public function ibuHamil()
    {
        return $this->hasOne(IbuHamil::class, 'user_id');
    }

    /**
     * Check if user is ibu hamil
     */
    public function isIbuHamil()
    {
        return $this->hasRole('ibu_hamil');
    }

    /**
     * Check if user is super_admin
     */
    public function isAdmin()
    {
        return $this->hasRole('super_admin');
    }

    /**
     * Check if user is super_admin
     */
    public function isPuskesmas()
    {
        return $this->hasRole('puskesmas');
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->isAdmin() || $this->isPuskesmas();
    }
}
