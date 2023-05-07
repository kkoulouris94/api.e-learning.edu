<?php

namespace App\Http\Services\Enrollments;

use App\Models\Completion;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class EnrollmentService
{
    public function enroll(int $courseId, int $userId)
    {
        // Get student of current user
        $studentId = User::findOrFail($userId)->type->id;

        // Validate that the course exists
        Course::findOrFail($courseId);

        // Check if current student has already signed for this course
        $enrollment = Enrollment::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->first();

        if ($enrollment) {
            throw new BadRequestException('Already enrolled in this course');
        }

        // Enroll student to course
        return Enrollment::create([
            'course_id' => $courseId,
            'student_id' => $studentId
        ]);
    }

    public function complete(int $id, int $userId): Model|bool
    {
        $studentId = User::findOrFail($userId)->type->id;

        /** @var Enrollment $enrollment */
        $enrollment = Enrollment::where('course_id', $id)
            ->where('student_id', $studentId)
            ->firstOrFail();
        if ($enrollment->student_id !== $studentId)
        {
            throw new UnauthorizedException('You don\'t have permission to access this resource');
        }

        $completion = Completion::where('enrollment_id', $id)
            ->first();
        if ($completion)
        {
            throw new BadRequestException('You have already completed this course');
        }

        $completion = new Completion();
        return $enrollment->completion()->save($completion);
    }
}
