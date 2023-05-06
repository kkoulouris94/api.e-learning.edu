<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use Faker\Generator;
use Illuminate\Container\Container;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    protected $faker;

    public function __construct()
    {
        $this->faker = $this->withFaker();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Course::factory()
            ->count(50)
            ->create();

        $students = Student::factory()
            ->count(50)
            ->create();
        foreach ($students as $student)
        {
            /** @var User $user */
            $student->user()->create([
                'email' => $this->faker->safeEmail(),
                'password' => Hash::make('123456789')
            ]);
        }
    }

    /**
     * @throws BindingResolutionException
     */
    private function withFaker()
    {
        return Container::getInstance()->make(Generator::class);
    }
}
