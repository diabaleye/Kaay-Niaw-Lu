<?php

namespace Database\Factories;

use App\Enums\StatutCommande;
use App\Models\Modele;
use App\Models\TailleurProfile;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommandeFactory extends Factory
{
    public function definition(): array
    {
        return [
            'client_id' => User::factory()->client(),
            'tailleur_profile_id' => TailleurProfile::factory(),
            'modele_id' => Modele::factory(),
            'statut' => fake()->randomElement(StatutCommande::cases()),
            'prix_convenu' => fake()->randomFloat(2, 15000, 150000),
            'date_livraison_souhaitee' => fake()->dateTimeBetween('now', '+1 month'),
            'notes_client' => fake()->optional()->sentence(),
        ];
    }
}
