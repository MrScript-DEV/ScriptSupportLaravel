<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Services\User\UserService;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;

class UserController extends BaseController
{
    public function __construct(private UserService $_userService){}

    public function index(): JsonResponse
    {
        try {
            $users = $this->_userService->findAll();
            return $this->sendResponse(message:  __('OK'), result: UserResource::collection($users), code: 200);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function show(int $id): JsonResponse {
        try {
            if (!authenticatedUser()->can('viewAllUser') && !isOwner($id)) {
                return $this->sendError(message: __('Accès interdit'), code: 403);
            }

            $user = $this->_userService->find($id);
            return $this->sendResponse(message:  __('OK'), result: new UserResource($user), code: 200);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function create(UserCreateRequest $request): JsonResponse {
        try {
            $user = $this->_userService->create($request->validated());
            return $this->sendResponse(message:  __('OK'), result: new UserResource($user), code: 201);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function update(int $id, UserUpdateRequest $request): JsonResponse {
        try {
            if (!authenticatedUser()->can('editUser') && !isOwner($id)) {
                return $this->sendError(message: __('Accès interdit'), code: 403);
            }

            $user = $this->_userService->update($id, $request->validated());
            return $this->sendResponse(message:  __('OK'), result: new UserResource($user), code: 200);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function delete(int $id): JsonResponse {
        try {
            $this->_userService->delete($id);
            return $this->sendResponse(message:  __('OK'), code: 204);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        try {
            $this->_userService->destroy($id);
            return $this->sendResponse(message:  __('OK'), code: 204);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }
}
