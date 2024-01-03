<?php

namespace Database\Factories;

use App\Models\Petugas;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Petugas>
 */
class PetugasFactory extends Factory
{
    protected $model = Petugas::class;
    protected static ?string $password;
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
            'username' => fake()->name(),
            'level' => $levels ?? 'Admin',
            'password' => static::$password ?? Hash::make('password'),
        ];
    }
}
