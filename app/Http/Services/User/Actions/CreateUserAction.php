<?php

declare(strict_types=1);

namespace App\Http\Services\User\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUserAction
{
    public function execute(
        string $firstname,
        string $lastname,
        string $email,
        string $role,
        string $password
    ): User {
        DB::beginTransaction();

        try {
            $user = User::create([
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email,
                'password' => Hash::make($password),
            ]);

            $user->assignRole($role);

            DB::commit();

            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
