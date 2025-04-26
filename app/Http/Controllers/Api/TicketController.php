<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TicketResource;
use App\Http\Controllers\BaseController;
use App\Http\Services\Ticket\TicketService;
use App\Http\Requests\Ticket\TicketCreateRequest;
use App\Http\Requests\Ticket\TicketUpdateRequest;
use App\Http\Requests\Ticket\TicketUpdateRatingRequest;
use App\Http\Controllers\Api\Traits\HandlesApiException;

class TicketController extends BaseController
{
    use HandlesApiException;

    public function __construct(private TicketService $_ticketService){}

    public function index(Request $request): JsonResponse
    {
        try {
            $tickets = $this->_ticketService->findAll($request);
            return $this->sendResponse(message:  __('OK'), result: TicketResource::collection($tickets), code: 200);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function show(int $id): JsonResponse {
        try {
            if (!authenticatedUser()->can('viewAllTicket') && !isTicketOwner($id)) {
                abort(403, __('Accès interdit'));
            }

            $ticket = $this->_ticketService->find($id);
            return $this->sendResponse(message:  __('OK'), result: new TicketResource($ticket), code: 200);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function create(TicketCreateRequest $request): JsonResponse {
        try {
            $ticket = $this->_ticketService->create($request->validated());
            return $this->sendResponse(message:  __('OK'), result: new TicketResource($ticket), code: 201);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function update(int $id, TicketUpdateRequest $request): JsonResponse {
        try {
            if (!authenticatedUser()->can('editTicket')) {
                abort(403, __('Accès interdit'));
            }

            $ticket = $this->_ticketService->update($id, $request->validated());
            return $this->sendResponse(message:  __('OK'), result: new TicketResource($ticket), code: 200);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function updateRating(int $id, TicketUpdateRatingRequest $request): JsonResponse
    {
        try {
            if (!isTicketOwner($id)) {
                abort(403, __('Accès interdit'));
            }

            $ticket = $this->_ticketService->updateRating($id, $request->validated());
            return $this->sendResponse(message: __('OK'), result: new TicketResource($ticket), code: 200);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function delete(int $id): JsonResponse {
        try {
            $this->_ticketService->delete($id);
            return $this->sendResponse(message:  __('OK'), code: 204);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }

    public function destroy(int $id): JsonResponse {
        try {
            $this->_ticketService->destroy($id);
            return $this->sendResponse(message:  __('OK'), code: 204);
        } catch (\Throwable $e) {
            return $this->handleException($e);
        }
    }
}
