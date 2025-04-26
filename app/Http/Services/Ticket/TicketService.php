<?php

namespace App\Http\Services\Ticket;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use App\Http\Services\Ticket\Actions\FindTicketAction;
use App\Http\Services\Ticket\Actions\CreateTicketAction;
use App\Http\Services\Ticket\Actions\DeleteTicketAction;
use App\Http\Services\Ticket\Actions\UpdateTicketAction;
use App\Http\Services\Ticket\Actions\DestroyTicketAction;
use App\Http\Services\Ticket\Actions\FindAllTicketAction;
use App\Http\Services\Ticket\Actions\UpdateRatingTicketAction;

class TicketService
{
    public function __construct(
        private CreateTicketAction $createTicket,
        private FindAllTicketAction $findAllTicket,
        private FindTicketAction $findTicket,
        private UpdateTicketAction $updateTicket,
        private UpdateRatingTicketAction $updateRatingTicket,
        private DeleteTicketAction $deleteTicket,
        private DestroyTicketAction $destroyTicket,
    )
    {}

    public function findAll(Request $request): Collection {
        return $this->findAllTicket->execute($request);
    }

    public function find(int $id): Ticket {
        return $this->findTicket->execute(id: $id);
    }

    public function create(array $data): Ticket
    {
        return $this->createTicket->execute(
            subject: $data['subject'],
            priorityId: $data['priority_id'],
            messageContent: $data['message'],
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

    public function delete(int $id): void
    {
       $this->deleteTicket->execute(id: $id);
    }

    public function destroy(int $id): void
    {
       $this->destroyTicket->execute(id: $id);
    }
}
