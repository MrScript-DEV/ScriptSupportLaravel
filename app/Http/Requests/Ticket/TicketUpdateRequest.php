<?php

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => ['nullable', 'string', 'min:2', 'max:255'],
            'priority_id' => ['integer', 'exists:priorities,id'],
            'status_id' => ['integer', 'exists:statuses,id'],
            'assigned_to_id' => ['nullable', 'integer', 'exists:users,id'],
        ];
    }
}
