<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource) {
            return [
                'id' => $this->id,
                'user' => $this->user,
                'ticket' => $this->ticket,
                'message' => $this->message,
            ];
        }
        return [];
    }
}
