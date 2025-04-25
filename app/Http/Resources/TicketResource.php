<?php

declare(strict_types=1);

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
                'subject' => $this->subject,
                'rating' => (int) $this->rating,
                'user' => new UserResource($this->whenLoaded('user')),
                'assigned_to' => new UserResource($this->whenLoaded('assignedTo')),
                'priority' => $this->priority?->name,
                'status' => $this->status?->name,
                'messages' => MessageResource::collection($this->whenLoaded('messages')),
                'created_at' => $this->created_at?->diffForHumans(),
                'updated_at' => $this->updated_at?->diffForHumans(),
            ];
        }

        return [];
    }
}
