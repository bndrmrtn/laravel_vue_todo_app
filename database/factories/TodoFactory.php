<?php

namespace Database\Factories;

use App\Models\Group;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'current_status_id' => Status::pluck('id')->random(),
            'group_id' => Group::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
            'task' => $this->faker->text(70),
            'finished' => $this->faker->boolean(),
            'priority' => $this->faker->numberBetween(0,9),
        ];
    }
}
