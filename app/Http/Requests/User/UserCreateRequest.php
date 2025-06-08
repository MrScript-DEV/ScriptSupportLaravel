<?php

declare(strict_types=1);

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use App\Traits\PasswordValidationRules;
use Illuminate\Foundation\Http\FormRequest;

class UserCreateRequest extends FormRequest
{
    use PasswordValidationRules;

    public function rules(): array
    {
        $roles = Role::pluck('name')->toArray();

        return [
            'first_name' => 'required|string|min:2|max:255',
            'last_name' => 'required|string|min:2|max:255',
            'email' => 'required|email|unique:users,email',
            'role' => ['required', 'string', Rule::in($roles)],
            'password' => $this->passwordRules(),
        ];
    }
}
