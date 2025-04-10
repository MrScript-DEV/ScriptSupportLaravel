<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;

class TicketShowController extends BaseController
{
    public function show(int $ticketId): JsonResponse
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);

            if (!isAdmin() || !isSupport() || !isOwner($ticket->user_id)) {
                return $this->sendError(error: __('Non autorisé'), code: 403);
            }

            return $this->sendResponse(message: __('OK'), result: new TicketResource($ticket));
        } catch (\Exception $e) {
            if (app()->isLocal()) {
                return $this->sendError(error: __('Une erreur est survenue..'), errorMessages: $e, code: 500);
            }

            return $this->sendError(error: __('Une erreur est survenue..'), code: 500);
        }
    }
}
