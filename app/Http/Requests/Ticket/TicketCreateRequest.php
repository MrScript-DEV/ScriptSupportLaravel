<?php

declare(strict_types=1);

namespace App\Http\Requests\Ticket;

use Illuminate\Foundation\Http\FormRequest;

class TicketCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'subject' => ['required', 'string', 'min:2', 'max:255'],
            'priority_id' => ['required', 'exists:priorities,id'],
            'message' => ['required', 'string', 'min:2', 'max:1000'],
        ];
    }
}
