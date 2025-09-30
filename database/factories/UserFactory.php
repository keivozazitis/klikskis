<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name'  => fake()->lastName(),
            'email'      => fake()->unique()->safeEmail(),
            'password'   => bcrypt('password'),
            'remember_token' => Str::random(10),

            // Jaunie obligātie lauki
            'birth_date' => fake()->date(), // piem. "1990-05-21"
            'gender'     => fake()->randomElement(['male', 'female']),
            
            // Papildu kolonnas no tavas users tabulas
            'region_id'  => 1, // vai fake()->numberBetween(1,4)
            'weight'     => fake()->numberBetween(50, 120),
            'augums'     => fake()->numberBetween(150, 200),
        ];
    }
}
