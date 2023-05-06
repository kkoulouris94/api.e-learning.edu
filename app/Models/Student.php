<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Student extends User
{
    protected $table = 'students';

    protected $fillable = [
        'first_name',
        'last_name'
    ];

    public function user(): MorphOne
    {
        return $this->morphOne(User::class, 'type');
    }

    public function enrollments(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'enrollments');
    }
}
