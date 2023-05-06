<?php

namespace Database\Factories;

use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition()
    {
        return [
            'title' => $this->faker->catchPhrase(),
            'description' => $this->faker->paragraph(4),
            'instructor' => $this->faker->firstName(),
            'skill_level' => $this->faker->randomElement(['All Levels', 'Beginner', 'Intermediate', 'Advanced']),
            'lectures' => $this->faker->randomNumber(3)
        ];
    }
}
