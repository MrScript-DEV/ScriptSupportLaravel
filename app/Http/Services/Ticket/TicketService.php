<?php

namespace App\Http\Services\Ticket;

use App\Models\Ticket;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Services\Ticket\Actions\CreateTicketAction;
use App\Http\Services\Ticket\Actions\FindAllTicketAction;
use App\Http\Services\Ticket\Actions\FindTicketAction;
use App\Http\Services\Ticket\Actions\UpdateRatingTicketAction;
use App\Http\Services\Ticket\Actions\UpdateTicketAction;

class TicketService
{
    public function __construct(
        private CreateTicketAction $createTicket,
        private FindAllTicketAction $findAllTicket,
        private FindTicketAction $findTicket,
        private UpdateTicketAction $updateTicket,
        private UpdateRatingTicketAction $updateRatingTicket,
    )
    {}

    public function findAll(): Collection {
        return $this->findAllTicket->execute();
    }

    public function find(int $id): Ticket {
        return $this->findTicket->execute(id: $id);
    }

    public function create(array $data): Ticket
    {
        return $this->createTicket->execute(
            subject: $data['subject'],
            priorityId: $data['priority_id'],
            message: $data['message'],
        );
    }

    public function update(int $id, array $data): Ticket
    {
        return $this->updateTicket->execute(
            id: $id,
            subject: $data['subject'],
            statusId: $data['status_id'],
            priorityId: $data['priority_id'],
            assignedToId: $data['assigned_to_id']
        );
    }

    public function updateRating(int $id, array $data): Ticket
    {
        return $this->updateRatingTicket->execute(
            id: $id,
            rating: $data['rating'],
        );
    }
}
