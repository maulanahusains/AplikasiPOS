<?php

namespace Database\Factories;

use App\Models\Petugas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Petugas>
 */
class PetugasFactory extends Factory
{
    protected $model = Petugas::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $levels = $this->attributes['level'] ?? null;
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->userName(),
            'level' => $levels ?? 'Admin',
            'password' => bcrypt('password'),
        ];
    }
}
