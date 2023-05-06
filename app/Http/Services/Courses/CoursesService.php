<?php

namespace App\Http\Services\Courses;

use App\Http\Services\CrudService;
use App\Models\Course;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CoursesService implements CrudService
{

    public function findAll(): Collection
    {
        return Course::all();
    }

    public function findById(int $id): Model
    {
        return Course::findOrFail($id);
    }

    public function store(array $attributes): Model
    {
        return Course::create($attributes);
    }

    public function update(int $id, array $attributes): Model
    {
        /** @var Course $course */
        $course = Course::findOrFail($id);

        $course->fill($attributes);
        $course->save();

        return $course;
    }

    public function deleteById(int $id): int
    {
        return Course::destroy($id);
    }
}
