<?php

namespace App\Http\Services\Message;

use App\Models\Message;
use App\Http\Services\Message\Actions\CreateMessageAction;
use App\Http\Services\Message\Actions\DeleteMessageAction;
use App\Http\Services\Message\Actions\UpdateMessageAction;
use App\Http\Services\Message\Actions\DestroyMessageAction;


class MessageService
{
    public function __construct(
        private CreateMessageAction $createMessage,
        private UpdateMessageAction $updateMessage,
        private DeleteMessageAction $deleteMessage,
        private DestroyMessageAction $destroyMessage,
    )
    {}

    public function create(array $data): Message
    {
        return $this->createMessage->execute(
            ticketId: $data['ticket_id'],
            messageContent: $data['message'],
        );
    }

    public function update(int $id, array $data): Message
    {
        return $this->updateMessage->execute(
            id: $id,
            messageContent: $data['message'],
        );
    }

    public function delete(int $id): void
    {
       $this->deleteMessage->execute(id: $id);
    }

    public function destroy(int $id): void
    {
       $this->destroyMessage->execute(id: $id);
    }
}
