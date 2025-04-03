<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource) {
            return [
                'id' => $this->id,
                'user' => $this->user,
                'assignedTo' => $this->assignedTo,
                'subject' => $this->subject,
                'priority' => $this->priority,
                'status' => $this->status,
                'rating' => $this->rating,
                'messages' => $this->messages,
            ];
        }
        return [];
    }
}
