<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'tailleur_profile_id',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function tailleurProfile(): BelongsTo
    {
        return $this->belongsTo(TailleurProfile::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function dernierMessage(): HasOne
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
}
