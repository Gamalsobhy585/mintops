<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TaskFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'status' => $this->faker->randomElement(['completed', 'in progress', 'not started']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),
            'category_id' => Category::factory(),
            'user_id' => User::factory(),
        ];
    }
}
