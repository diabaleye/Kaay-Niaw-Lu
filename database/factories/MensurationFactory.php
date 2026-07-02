<?php

namespace Database\Factories;

use App\Models\Commande;
use Illuminate\Database\Eloquent\Factories\Factory;

class MensurationFactory extends Factory
{
    public function definition(): array
    {
        return [
            'commande_id' => Commande::factory(),
            'tour_poitrine' => fake()->randomFloat(2, 80, 130),
            'tour_taille' => fake()->randomFloat(2, 60, 110),
            'tour_hanches' => fake()->randomFloat(2, 80, 130),
            'longueur_manche' => fake()->randomFloat(2, 50, 70),
            'tour_cou' => fake()->randomFloat(2, 35, 50),
            'largeur_epaule' => fake()->randomFloat(2, 35, 50),
            'hauteur_totale' => fake()->randomFloat(2, 140, 190),
            'notes' => fake()->optional()->sentence(),
        ];
    }
}
