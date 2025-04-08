<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class TicketDeleteController extends BaseController
{
    public function delete(int $ticketId): JsonResponse
    {
        DB::beginTransaction();

        try {
            if (! isAdmin() || ! isSupport()) {
                return $this->sendError(error: __('Non autorisé'), code: 403);
            }

            $ticket = User::findOrFail($ticketId);

            $ticket->delete();
            DB::commit();

            return $this->sendResponse(message: __('OK'));

        } catch (\Exception $e) {
            DB::rollBack();

            if (app()->isLocal()) {
                return $this->sendError(error: __('Une erreur est survenue..'), errorMessages: $e, code: 500);
            }

            return $this->sendError(error: __('Une erreur est survenue..'), code: 500);
        }
    }
}
