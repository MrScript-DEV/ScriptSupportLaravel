<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource) {
            return [
                'id' => $this->id,
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'roles' => $this->roles->pluck('name'),
                'total_tickets' => $this->tickets()->count(),
                'tickets' => $this->whenLoaded('tickets'),
                'created_at' => $this->created_at,
                'updated_at' => $this->updated_at,
            ];
        }

        return [];
    }
}
