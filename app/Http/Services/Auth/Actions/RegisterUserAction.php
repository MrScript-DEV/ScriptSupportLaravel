<?php

declare(strict_types=1);

namespace App\Http\Services\Auth\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RegisterUserAction
{
    public function execute(
        string $firstname,
        string $lastname,
        string $email,
        string $password,
    ): void {
        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $user->assignRole('User');

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
