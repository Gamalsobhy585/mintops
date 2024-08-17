<?php
namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->company(),
            'leader_id' => User::factory(),
        ];
    }
}
