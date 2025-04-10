<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PriorityResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        if ($this->resource) {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'level' => $this->level,
                'tickets' => $this->tickets,
            ];
        }

        return [];
    }
}
