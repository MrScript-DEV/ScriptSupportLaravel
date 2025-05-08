<?php

declare(strict_types=1);

namespace App\Http\Services\Ticket\Actions;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DeleteTicketAction
{
    public function execute(int $id): void
    {
        DB::beginTransaction();

        try {
            $ticket = Ticket::findOrFail($id);

            $ticket->messages()->delete();

            $ticket->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
