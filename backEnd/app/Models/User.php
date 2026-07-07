<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'prenom', 'nom', 'pseudo',
        'telephone', 'workshop_name', 'location', 'specialties',
        'max_orders', 'avg_production_time',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function ordersAsClient(): HasMany
    {
        return $this->hasMany(Order::class, 'client_id');
    }

    public function ordersAsTailor(): HasMany
    {
        return $this->hasMany(Order::class, 'tailor_id');
    }

    public function measurement(): HasOne
    {
        return $this->hasOne(Measurement::class);
    }

    public function modeles(): HasMany
    {
        return $this->hasMany(Modele::class, 'tailor_id');
    }

    public function settings(): HasOne
    {
        return $this->hasOne(UserSetting::class);
    }
}
