<?php

declare(strict_types=1);

namespace App\Http\Services\Auth;

use App\Http\Services\Auth\Actions\LoginUserAction;
use App\Http\Services\Auth\Actions\RegisterUserAction;
use App\Http\Services\Auth\Actions\LogoutUserAction;
use Illuminate\Http\Request;

class AuthService
{
    public function __construct(
        private RegisterUserAction $registerUser,
        private LoginUserAction $loginUser,
        private LogoutUserAction $logoutUser,
    ) {
    }

    public function register(array $data): void
    {
        $this->registerUser->execute(
            firstname: $data['first_name'],
            lastname: $data['last_name'],
            email: $data['email'],
            password: $data['password'],
        );
    }

    public function login(string $email, string $password): array
    {
        return $this->loginUser->execute(
            email: $email,
            password: $password,
        );
    }

    public function logout(Request $request): void
    {
        $this->logoutUser->execute($request);
    }
}
