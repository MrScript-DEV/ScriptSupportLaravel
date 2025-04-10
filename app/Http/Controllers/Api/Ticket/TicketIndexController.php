<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;

class TicketIndexController extends BaseController
{
    public function index(): JsonResponse
    {
        try {
            if (!isAdmin() && !isSupport()) {
                $tickets = Ticket::where('user_id', authenticatedUser()->id)->get();
            } else {
                $tickets = Ticket::all();
            }

            return $this->sendResponse(message: __('OK'), result: TicketResource::collection($tickets));
        } catch (\Exception $e) {
            if (app()->isLocal()) {
                return $this->sendError(error: __('Une erreur est survenue..'), errorMessages: $e, code: 500);
            }

            return $this->sendError(error: __('Une erreur est survenue..'), code: 500);
        }
    }
}
