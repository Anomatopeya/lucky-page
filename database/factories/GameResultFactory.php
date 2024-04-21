<?php

namespace Database\Factories;

use App\Models\GameResult;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class GameResultFactory extends Factory
{
    protected $model = GameResult::class;

    public function definition(): array
    {
        return [
            'score' => $this->faker->randomNumber(),
            'is_win' => $this->faker->boolean(),
            'win_amount' => round($this->faker->randomFloat(1000, 0, 1000)),

            'user_id' => User::factory(),
        ];
    }
}
