<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use App\Http\Resources\TicketResource;
use App\Http\Controllers\BaseController;
use App\Http\Services\Ticket\TicketService;
use App\Http\Requests\Ticket\TicketCreateRequest;
use App\Http\Requests\Ticket\TicketUpdateRequest;
use App\Http\Requests\Ticket\TicketUpdateRatingRequest;

class TicketController extends BaseController
{
    public function __construct(private TicketService $_ticketService){}

    public function index(): JsonResponse
    {
        try {
            $tickets = $this->_ticketService->findAll();
            return $this->sendResponse(message:  __('OK'), result: TicketResource::collection($tickets), code: 200);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function show(int $id): JsonResponse {
        try {
            if (!authenticatedUser()->can('viewAllTicket') && !isTicketOwner($id)) {
                return $this->sendError(message: __('Accès interdit'), code: 403);
            }

            $ticket = $this->_ticketService->find($id);
            return $this->sendResponse(message:  __('OK'), result: new TicketResource($ticket), code: 200);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function create(TicketCreateRequest $request): JsonResponse {
        try {
            $ticket = $this->_ticketService->create($request->validated());
            return $this->sendResponse(message:  __('OK'), result: new TicketResource($ticket), code: 201);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function update(int $id, TicketUpdateRequest $request): JsonResponse {
        try {
            if (!authenticatedUser()->can('editTicket')) {
                return $this->sendError(message: __('Accès interdit'), code: 403);
            }

            $ticket = $this->_ticketService->update($id, $request->validated());
            return $this->sendResponse(message:  __('OK'), result: new TicketResource($ticket), code: 200);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function updateRating(int $id, TicketUpdateRatingRequest $request): JsonResponse
    {
        try {
            if (!isTicketOwner($id)) {
                return $this->sendError(message: __('Accès interdit'), code: 403);
            }

            $ticket = $this->_ticketService->updateRating($id, $request->validated());
            return $this->sendResponse(message: __('OK'), result: new TicketResource($ticket), code: 200);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function delete(int $id): JsonResponse {
        try {
            $this->_ticketService->delete($id);
            return $this->sendResponse(message:  __('OK'), code: 204);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }

    public function destroy(int $id): JsonResponse {
        try {
            $this->_ticketService->destroy($id);
            return $this->sendResponse(message:  __('OK'), code: 204);
        } catch (\Exception $e) {
            return $this->sendError(message: $e->getMessage(), code: $e->getCode() ?: 500);
        }
    }
}
