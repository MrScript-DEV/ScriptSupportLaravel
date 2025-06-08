<?php

declare(strict_types=1);

namespace App\Http\Services\Ticket\Actions;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class UpdateTicketAction
{
    public function execute(
        int $id,
        string $subject,
        int $statusId,
        int $priorityId,
        ?int $assignedToId = null,
    ): Ticket {
        DB::beginTransaction();

        try {
            $relations = ['assignedTo', 'user', 'messages'];

            $ticket = Ticket::with($relations)->findOrFail($id);

            $ticket->update([
                'subject' => $subject,
            ]);

            $ticket->status()->associate($statusId);
            $ticket->priority()->associate($priorityId);

            if (!is_null($assignedToId)) {
                $ticket->assignedTo()->associate($assignedToId);
            } else {
                $ticket->assignedTo()->dissociate();
            }

            $ticket->save();

            DB::commit();


            return $ticket;
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
