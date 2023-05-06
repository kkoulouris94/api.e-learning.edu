<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Enrollment extends Model
{
    protected $fillable = [
        'course_id',
        'student_id'
    ];

    public function completion(): HasOne
    {
        return $this->hasOne(Completion::class);
    }
}
