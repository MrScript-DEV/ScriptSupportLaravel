<?php

declare(strict_types=1);

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\PasswordValidationRules;

class RegisterRequest extends FormRequest
{
    use PasswordValidationRules;

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => $this->passwordRules(),
        ];
    }
}
