<?php

namespace App\Http\Requests\Priority;

use Illuminate\Foundation\Http\FormRequest;

class PriorityUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'min:2',
                'max:255',
                'unique:priorities,name',
            ],
            'level' => [
                'required',
                'integer',
                'min:1',
                'max:10',
                'unique:priorities,level',
            ],
        ];
    }
}
