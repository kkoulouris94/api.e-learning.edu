<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware(
            'auth:api',
            ['except' => [
                'register',
                'login',
                'logout'
            ]]
        );
    }

    /**
     * @throws ValidationException
     */
    public function register(Request $request): JsonResponse
    {
        $rules = [
            'first_name' => 'required|max:255|string',
            'last_name' => 'required|max:255|string',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|max:20',
        ];
        $this->validate($request, $rules);

        // Create student entity
        $studentDetails = $request->only(['first_name', 'last_name']);
        $student = Student::create($studentDetails);

        // Create User entity
        $credentials = $request->only(['email', 'password']);
        $credentials['password'] = Hash::make($credentials['password']);
        $user = $student->user()->create($credentials);

        // Login the user
        $token = Auth::login($user);

        return $this->respondWithToken($token);
    }

    /**
     * @throws ValidationException
     * @throws AuthenticationException
     */
    public function login(Request $request): JsonResponse
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required|min:6|max:20'
        ];
        $this->validate($request, $rules);

        $credentials = $request->only(['email', 'password']);
        if (!$token = Auth::attempt($credentials)) {
            throw new AuthenticationException('Unauthorized');
        }

        return $this->respondWithToken($token);
    }

    public function me(): JsonResponse
    {
        // Get student entity
        /** @var Student $student */
        $student = Auth::user()->type;

        $enrollments = Enrollment::with(['course', 'completion'])
            ->where('student_id', $student->id)
            ->get()
            ->map(function ($enrollment) {
                $returnedValue = $enrollment->course;
                $returnedValue['completed'] = $enrollment->completion !== null;
                return $returnedValue;
            });

        return $this->successResponse([
            'courses' => $enrollments,
            'info' => Auth::user()
        ]);
    }

    public function logout(): JsonResponse
    {
        \auth()->logout();

        return $this->successResponse(null, ResponseAlias::HTTP_NO_CONTENT);
    }

    protected function respondWithToken($token): JsonResponse
    {
        return $this->successResponse([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => \auth()->user(),
            'expires_in' => \auth()->factory()->getTTL() * 60 * 24
        ]);
    }
}
