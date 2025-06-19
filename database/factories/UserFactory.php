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
            // 'name' => fake()->name(), // この行はコメントアウトまたは削除
            'username' => fake()->userName(), // 'username' を追加し、fake()->userName() を使用
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            // 追加したカラムのテストデータ生成
            'profile_image' => null, // または fake()->imageUrl() など、必要に応じてダミーデータを生成
            'self_introduction' => fake()->paragraph(),
            'last_login_at' => fake()->dateTimeThisYear(),
            'registered_at' => now(),
            'role' => fake()->randomElement(['general', 'admin']),
            'is_active' => true,
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
}