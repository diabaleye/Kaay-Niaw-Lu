<?php

namespace Database\Factories;

use App\Enums\RoleUtilisateur;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'role' => RoleUtilisateur::Client,
            'telephone' => fake()->phoneNumber(),
            'remember_token' => Str::random(10),
        ];
    }

    public function client(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => RoleUtilisateur::Client,
        ]);
    }

    public function tailleur(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => RoleUtilisateur::Tailleur,
        ]);
    }

    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => RoleUtilisateur::Admin,
        ]);
    }
}
