<?php

declare(strict_types=1);

namespace App\Http\Services\Auth\Actions;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginUserAction
{
    public function execute(
        string $email,
        string $password,
    ): array {
        DB::beginTransaction();

        try {
            $user = User::where('email', $email)->first();

            if (!$user || !Hash::check($password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Identifiants invalides.'],
                ]);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            DB::commit();

            return [
                'user' => new UserResource($user),
                'token' => $token,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
