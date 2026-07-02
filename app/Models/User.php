<?php

namespace App\Models;

use App\Enums\RoleUtilisateur;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * IMPORTANT : 'nom' et non 'name' (convention Laravel remplacee).
     * 'telephone' est un string — jamais un int (voir note architecture).
     * 'role' est cast en enum RoleUtilisateur.
     */
    protected $fillable = [
        'nom',
        'email',
        'telephone',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'role'              => RoleUtilisateur::class,
        ];
    }

    // ─── Relations ───────────────────────────────────────────────

    public function tailleurProfile(): HasOne
    {
        return $this->hasOne(TailleurProfile::class);
    }

    public function profilMesures(): HasOne
    {
        return $this->hasOne(ProfilMesures::class, 'client_id');
    }

    public function commandesPassees(): HasMany
    {
        return $this->hasMany(Commande::class, 'client_id');
    }

    public function conversationsEnTantQueClient(): HasMany
    {
        return $this->hasMany(Conversation::class, 'client_id');
    }

    public function messagesEnvoyes(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function avisRediges(): HasMany
    {
        return $this->hasMany(Avis::class, 'client_id');
    }

    // ─── Helpers de role ─────────────────────────────────────────

    public function estTailleur(): bool
    {
        return $this->role === RoleUtilisateur::Tailleur;
    }

    public function estAdmin(): bool
    {
        return $this->role === RoleUtilisateur::Admin;
    }

    public function estClient(): bool
    {
        return $this->role === RoleUtilisateur::Client;
    }
}