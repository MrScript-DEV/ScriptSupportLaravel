<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserResource;
use App\Http\Services\User\UserService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\User\UserCreateRequest;
use App\Http\Requests\User\UserUpdateRequest;
use App\Http\Controllers\Api\Traits\HandlesApiException;
use Illuminate\Http\Request;

class UserController extends BaseController
{
    use HandlesApiException;

    public function __construct(private UserService $_userService){}

    public function index(Request $request): JsonResponse
    {
        try {
            $users = $this->_userService->findAll($request);
            return $this->sendResponse(message:  __('OK'), result: UserResource::collection($users), code: 200);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function show(int $id): JsonResponse {
        try {
            if (!authenticatedUser()->can('viewAllUser') && !isOwner($id)) {
                abort(403, __('Access Denied'));
            }

            $user = $this->_userService->find($id);
            return $this->sendResponse(message:  __('OK'), result: new UserResource($user), code: 200);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(UserCreateRequest $request): JsonResponse {
        try {
            $user = $this->_userService->create($request->validated());
            return $this->sendResponse(message:  __('OK'), result: new UserResource($user), code: 201);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(int $id, UserUpdateRequest $request): JsonResponse {
        try {
            if (!authenticatedUser()->can('editUser') && !isOwner($id)) {
                abort(403, __('Access Denied'));
            }

            $user = $this->_userService->update($id, $request->validated());
            return $this->sendResponse(message:  __('OK'), result: new UserResource($user), code: 200);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function delete(int $id): JsonResponse {
        try {
            $this->_userService->delete($id);
            return $this->sendResponse(message:  __('OK'), code: 204);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(int $id): JsonResponse {
        try {
            $this->_userService->destroy($id);
            return $this->sendResponse(message:  __('OK'), code: 204);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }
}
