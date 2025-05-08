<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\MessageResource;
use App\Http\Controllers\BaseController;
use App\Http\Services\Message\MessageService;
use App\Http\Requests\Message\MessageCreateRequest;
use App\Http\Requests\Message\MessageUpdateRequest;
use App\Http\Controllers\Api\Traits\HandlesApiException;

class MessageController extends BaseController
{
    use HandlesApiException;

    public function __construct(private MessageService $_messageService)
    {
    }

    public function create(MessageCreateRequest $request): JsonResponse
    {
        try {
            if (!authenticatedUser()->can('viewAllTicket') && !isTicketOwner((int) $request->validated()['ticket_id'])) {
                abort(403, __('Access Denied'));
            }

            $message = $this->_messageService->create($request->validated());

            return $this->sendResponse(message:  __('OK'), result: new MessageResource($message), code: 201);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(int $id, MessageUpdateRequest $request): JsonResponse
    {
        try {
            $message = $this->_messageService->update($id, $request->validated());

            return $this->sendResponse(message:  __('OK'), result: new MessageResource($message), code: 200);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function delete(int $id): JsonResponse
    {
        try {
            $this->_messageService->delete($id);

            return $this->sendResponse(message:  __('OK'), code: 200);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            $this->_messageService->destroy($id);

            return $this->sendResponse(message:  __('OK'), code: 200);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }
}
