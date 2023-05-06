<?php

namespace App\Http\Controllers\Enrollments;

use App\Http\Controllers\Controller;
use App\Http\Services\Enrollments\EnrollmentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class EnrollmentsController extends Controller
{
    private EnrollmentService $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;

        $this->middleware('auth:api');
    }

    /**
     * @throws \Exception
     */
    public function complete(int $id): JsonResponse
    {
        $userId = Auth::user()->getAuthIdentifier();

        $completion = $this->enrollmentService->complete($id, $userId);
        if (!$completion)
            throw new \Exception();

        return $this->successResponse($completion, Response::HTTP_CREATED);
    }
}
