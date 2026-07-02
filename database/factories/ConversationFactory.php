<?php

namespace Database\Factories;

use App\Models\TailleurProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConversationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => User::factory()->client(),
            'tailleur_profile_id' => TailleurProfile::factory(),
        ];
    }
}
