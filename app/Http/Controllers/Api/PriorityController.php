<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use App\Http\Services\Priority\PriorityService;
use App\Http\Controllers\Api\Traits\HandlesApiException;
use App\Http\Requests\Priority\PriorityCreateRequest;
use App\Http\Requests\Priority\PriorityUpdateRequest;
use App\Http\Resources\PriorityResource;

class PriorityController extends BaseController
{
    use HandlesApiException;

    public function __construct(private PriorityService $_priorityService) {}

    public function index(): JsonResponse
    {
        try {
            $priorities = $this->_priorityService->findAll();
            return $this->sendResponse(message:  __('OK'), result: PriorityResource::collection($priorities), code: 200);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function show(int $id): JsonResponse {
        try {
            $priority = $this->_priorityService->find($id);
            return $this->sendResponse(message:  __('OK'), result: new PriorityResource($priority), code: 200);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(PriorityCreateRequest $request): JsonResponse {
        try {
            $priority = $this->_priorityService->create($request->validated());
            return $this->sendResponse(message:  __('OK'), result: new PriorityResource($priority), code: 201);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(int $id, PriorityUpdateRequest $request): JsonResponse {
        try {
            $priority = $this->_priorityService->update($id, $request->validated());
            return $this->sendResponse(message:  __('OK'), result: new PriorityResource($priority), code: 200);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function delete(int $id): JsonResponse {
        try {
            $this->_priorityService->delete($id);
            return $this->sendResponse(message:  __('OK'), code: 204);
        }  catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }
}
