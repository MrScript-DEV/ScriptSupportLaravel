<?php

namespace App\Http\Services\Ticket\Actions;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class UpdateRatingTicketAction
{
    public function execute(
        int $id,
        string $rating,
    ): Ticket
    {
        DB::beginTransaction();

        try {
            $relations = ['assignedTo', 'user', 'messages'];

            $ticket = Ticket::with($relations)->findOrFail($id);
            $ticket->update([
                'rating' => $rating,
            ]);

            DB::commit();

            return $ticket;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
