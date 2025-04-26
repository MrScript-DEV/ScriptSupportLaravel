<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\StatusResource;
use App\Http\Controllers\BaseController;
use App\Http\Services\Status\StatusService;
use App\Http\Requests\Status\StatusCreateRequest;
use App\Http\Controllers\Api\Traits\HandlesApiException;
use App\Models\Status;

class StatusController extends BaseController
{
    use HandlesApiException;

    public function __construct(private StatusService $_statusService){}

    public function index(): JsonResponse
    {
        try {
            $statuses = $this->_statusService->findAll();
            return $this->sendResponse(message:  __('OK'), result: StatusResource::collection($statuses), code: 200);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function show(int $id): JsonResponse {
        try {
            $status = $this->_statusService->find($id);
            return $this->sendResponse(message:  __('OK'), result: new StatusResource($status), code: 200);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(StatusCreateRequest $request): JsonResponse {
        try {
            $status = $this->_statusService->create($request->validated());
            return $this->sendResponse(message:  __('OK'), result: new StatusResource($status), code: 201);
        }
        catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }
}
