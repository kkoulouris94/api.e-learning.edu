<?php

namespace App\Http\Controllers\Courses;

use App\Http\Controllers\Controller;
use App\Http\Services\Courses\CoursesService;
use App\Http\Services\Enrollments\EnrollmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CoursesController extends Controller
{
    private CoursesService $courseService;

    private EnrollmentService $enrollmentService;

    public function __construct(CoursesService $coursesService, EnrollmentService $enrollmentService)
    {
        $this->courseService = $coursesService;
        $this->enrollmentService = $enrollmentService;

        $this->middleware('auth:api');
    }

    public function listAll(): JsonResponse
    {
        $courses = $this->courseService->findAll();

        return $this->successResponse($courses);
    }

    public function showOne(int $id): JsonResponse
    {
        $course = $this->courseService->findById($id);

        return $this->successResponse($course);
    }

    public function enroll(int $id): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();

        $enrollment = $this->enrollmentService->enroll($id, $userId);

        return $this->successResponse($enrollment, Response::HTTP_CREATED);
    }
}
