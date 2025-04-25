<?php

namespace App\Http\Services\Ticket\Actions;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;

class FindAllTicketAction
{
    public function execute(): Collection
    {
        $relations = ['assignedTo', 'user'];

        if (authenticatedUser()->can('viewAllTicket')) {
            return Ticket::with($relations)->get();
        }

        return authenticatedUser()->tickets()->with($relations)->get();
    }
}
