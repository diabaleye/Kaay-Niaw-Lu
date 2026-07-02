<?php

namespace Database\Factories;

use App\Models\Modele;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModeleImageFactory extends Factory
{
    public function definition(): array
    {
        return [
            'modele_id' => Modele::factory(),
            'url' => fake()->imageUrl(640, 480, 'fashion'),
            'ordre' => 0,
        ];
    }
}
