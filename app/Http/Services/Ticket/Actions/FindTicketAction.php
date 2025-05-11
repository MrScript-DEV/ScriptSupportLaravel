<?php

declare(strict_types=1);

namespace App\Http\Services\Ticket\Actions;

use App\Models\Ticket;

class FindTicketAction
{
    public function execute(int $id): Ticket
    {
        $relations = ['assignedTo', 'user', 'messages.user'];

        return Ticket::with($relations)->findOrFail($id);
    }
}
