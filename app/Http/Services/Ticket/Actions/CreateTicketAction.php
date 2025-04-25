<?php

namespace App\Http\Services\Ticket\Actions;

use App\Models\Status;
use App\Models\Ticket;
use App\Models\Message;
use App\Models\Priority;
use Illuminate\Support\Facades\DB;

class CreateTicketAction
{
    public function execute(
        string $subject,
        int $priorityId,
        string $message,
    ): Ticket
    {
        DB::beginTransaction();

        try {
            $ticket = new Ticket([
                'subject' => $subject,
            ]);

            $ticket->user()->associate(authenticatedUser());
            $ticket->priority()->associate(Priority::findOrFail($priorityId));
            $ticket->status()->associate(Status::where('name', 'Ouvert')->firstOrFail());

            $ticket->save();

            $message = new Message([
                'content' => $message,
            ]);

            $message->user()->associate(authenticatedUser());
            $message->ticket()->associate($ticket);

            $message->save();

            DB::commit();

            return $ticket;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
