<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Services\Auth\AuthService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends BaseController
{
    public function __construct(private AuthService $authService)
    {
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $this->authService->register($request->validated());

            return $this->sendResponse(message:  __('OK'), code: 201);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $credentials = $request->validated();

            $auth = $this->authService->login(
                $credentials['email'],
                $credentials['password']
            );

            return $this->sendResponse(message:  __('OK'), result: $auth, code: 200);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authService->logout($request);

            return $this->sendResponse(message:  __('OK'), code: 200);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }
}
