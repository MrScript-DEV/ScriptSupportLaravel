<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class MessageCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'ticket_id' => ['required', 'integer', 'exists:tickets,id'],
            'message' => ['required', 'string', 'min:2', 'max:1000'],
        ];
    }
}
