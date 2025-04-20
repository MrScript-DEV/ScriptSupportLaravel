<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Ticket;

use App\Http\Controllers\Api\BaseController;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TicketUpdateController extends BaseController
{
    public function update(Request $request, int $ticketId): JsonResponse
    {
        try {
            $ticket = Ticket::findOrFail($ticketId);

            if (!isAdmin() || !isSupport() || !isOwner($ticket->user_id)) {
                return $this->sendError(error: __('Non autorisé'), code: 403);
            }

            $validator = Validator::make($request->all(), [
                'subject' => 'required|string|min:2|max:255',
                'rating' => 'number|min:0|max:5',
            ]);

            if ($validator->fails()) {
                return $this->sendError(error: __('Erreur de validation :'), errorMessages: $validator->errors()->all(), code: 422);
            }

            $data = [
                'subject' => $request->input('subject'),
                'rating' => $request->input('rating') ?? null,
            ];

            if (isAdmin() && $ticket->assignable_to !== $request->input('assignable_to')) {
                $data['assignable_to'] = $request->input('assignable_to') ?? null;
            }

            DB::beginTransaction();
            $ticket->update($data);
            DB::commit();

            return $this->sendResponse(message: __('OK'), result: new TicketResource($ticket));
        } catch (\Exception $e) {
            DB::rollBack();

            if (app()->isLocal()) {
                return $this->sendError(error: __('Une erreur est survenue..'), errorMessages: $e, code: 500);
            }

            return $this->sendError(error: __('Une erreur est survenue..'), code: 500);
        }
    }
}
