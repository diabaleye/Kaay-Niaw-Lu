<?php

namespace Database\Factories;

use App\Models\TailleurProfile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModeleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'tailleur_profile_id' => TailleurProfile::factory(),
            'titre' => ucfirst(fake()->words(3, true)),
            'description' => fake()->paragraph(),
            'prix' => fake()->randomFloat(2, 15000, 150000),
            'categorie' => fake()->randomElement(['boubou', 'costume', 'robe', 'ensemble']),
            'delai_realisation_jours' => fake()->numberBetween(3, 21),
            'actif' => true,
        ];
    }
}
