<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Measurement extends Model
{
    protected $fillable = [
        'user_id', 'cou', 'poitrine', 'bras', 'taille',
        'epaule', 'hanches', 'jambes', 'cuisses',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
