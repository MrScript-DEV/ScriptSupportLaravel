<?php

declare(strict_types=1);

namespace App\Http\Requests\Status;

use Illuminate\Foundation\Http\FormRequest;

class StatusCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255', 'unique:statuses,name'],
        ];
    }
}
