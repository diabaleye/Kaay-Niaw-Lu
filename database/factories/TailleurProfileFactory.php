<?php

namespace Database\Factories;

use App\Enums\StatutValidationTailleur;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TailleurProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory()->tailleur(),
            'ville' => fake()->city(),
            'bio' => fake()->paragraph(),
            'statut_validation' => StatutValidationTailleur::Valide,
            'note_moyenne' => fake()->randomFloat(2, 3, 5),
            'nombre_avis' => fake()->numberBetween(0, 50),
        ];
    }

    public function enAttente(): static
    {
        return $this->state(fn (array $attributes) => [
            'statut_validation' => StatutValidationTailleur::EnAttente,
        ]);
    }
}
