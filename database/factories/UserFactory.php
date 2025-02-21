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
            'name' => fake()->name(),
            'email' => $this->generateKSUEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'grade' => fake()->numberBetween(1, 4),
            'admin' => false,
            'birthday' => fake()->date()
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Generate a Kyoto Sangyo University email with a 6-digit sequence where the sum of digits is a multiple of 5.
     */
    private function generateKSUEmail(): string
    {
        do {
            $digits = str_pad(fake()->numberBetween(0, 999999), 6, '0', STR_PAD_LEFT);
            $sumOfDigits = array_sum(str_split($digits));
        } while ($sumOfDigits % 5 !== 0);

        return "g2{$digits}cc.kyoto-su.ac.jp";
    }
}
