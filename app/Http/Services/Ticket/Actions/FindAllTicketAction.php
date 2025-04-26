<?php

namespace App\Http\Services\Ticket\Actions;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class FindAllTicketAction
{
    public function execute(Request $request): Collection
    {
        $relations = ['assignedTo', 'user'];

        $query = authenticatedUser()->can('viewAllTicket')
            ? Ticket::query()
            : authenticatedUser()->tickets();

        $query->with($relations)
            ->when($request->filled('status_id'), fn($q) => $q->where('status_id', $request->status_id))
            ->when($request->filled('priority_id'), fn($q) => $q->where('priority_id', $request->priority_id))
            ->when($request->filled('subject'), fn($q) => $q->where('subject', 'like', '%' . $request->subject . '%'));

        return $query->get();
    }
}
