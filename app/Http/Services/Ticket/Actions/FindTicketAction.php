<?php

namespace App\Http\Services\Ticket\Actions;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

class FindTicketAction
{
    public function execute(int $id): Ticket
    {
        $relations = ['assignedTo', 'user', 'messages'];

        return Ticket::with($relations)->findOrFail($id);
    }
}
