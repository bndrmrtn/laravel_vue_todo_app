<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timelog>
 */
class TimelogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $created = $this->faker->dateTimeBetween('-20 days', now());
        $created->setTime(8,0,0);
        $updated = \DateTime::createFromFormat("Y-m-d h:i:s",$created->format("Y-m-d h:i:s"));
        // $updated->add(new \DateInterval("PT".rand(1,4)."H"));
        $updated->add(new \DateInterval("PT".rand(3600,14400)."S"));
        return [
            'todo_id' => Todo::pluck('id')->random(),
            'user_id' => User::pluck('id')->random(),
            'finished' => $this->faker->boolean(),
            'created_at' => $created,
            'updated_at' => $updated,
        ];
    }
}
