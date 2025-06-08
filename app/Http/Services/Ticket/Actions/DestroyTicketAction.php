<?php

declare(strict_types=1);

namespace App\Http\Services\Ticket\Actions;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;

class DestroyTicketAction
{
    public function execute(int $id): void
    {
        DB::beginTransaction();

        try {
            $ticket = Ticket::onlyTrashed()->findOrFail($id);

            $ticket->messages()->withTrashed()->forceDelete();

            $ticket->forceDelete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
