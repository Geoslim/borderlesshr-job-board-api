<?php

namespace App\Http\Controllers\API\v1\Candidate;

use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\LoginRequest;
use App\Http\Requests\Company\RegisterRequest;
use App\Services\Candidate\AuthService;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @param RegisterRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $response = $this->authService->register($request->validated());
            return $this->successResponse($response);
        } catch (Exception $e) {
            Log::error('candidate sign up error:: ', [$e]);
            return $this->error('Unable to sign up. Kindly try again later.');
        }
    }

    /**
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $response = $this->authService->login($request->validated());
            return $this->successResponse($response);
        } catch (AuthException$e) {
            Log::error('candidate login error:: ', [$e]);
            return $this->error($e->getMessage());
        } catch (Exception $e) {
            Log::error('candidate login error:: ', [$e]);
            return $this->error('Login attempt failed. Kindly try again later.');
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request->user());
            return $this->success('Successfully logged out');
        } catch (Exception $e) {
            Log::error('Error logging out:: ' . $e);
            return $this->error('Logout attempt failed. Kindly try again later.');
        }
    }
}
