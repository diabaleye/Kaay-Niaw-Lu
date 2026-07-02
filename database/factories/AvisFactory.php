<?php

namespace Database\Factories;

use App\Enums\StatutAvis;
use App\Models\Commande;
use App\Models\TailleurProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AvisFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => User::factory()->client(),
            'tailleur_profile_id' => TailleurProfile::factory(),
            'commande_id' => Commande::factory(),
            'note' => fake()->numberBetween(1, 5),
            'commentaire' => fake()->optional()->paragraph(),
            'statut' => StatutAvis::Visible,
        ];
    }
}
