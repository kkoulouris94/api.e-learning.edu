<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'title',
        'description',
        'instructor',
        'skill_level',
        'lectures'
    ];

    public function enroll(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'enrollments');
    }
}
