<?php

namespace App\Http\Services\Message\Actions;

use App\Models\Ticket;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CreateMessageAction
{
    public function execute(
        int $ticketId,
        string $messageContent,
    ): Message
    {
        DB::beginTransaction();

        try {
            $ticket = Ticket::findOrFail($ticketId);

            if ($ticket->status->name === 'Fermé') {
                abort(422, __("Impossible d'ajouter un message sur un ticket fermé."));
            }

            $message = new Message([
                'content' => $messageContent,
            ]);

            $message->user()->associate(authenticatedUser());
            $message->ticket()->associate($ticket);

            $message->save();

            DB::commit();

            return $message;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
