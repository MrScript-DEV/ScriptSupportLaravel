<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StatusResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource) {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'tickets' => $this->tickets,
            ];
        }

        return [];
    }
}
