<?php

namespace App\Http\Services\User\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class UpdateUserAction
{
    public function execute(
        int $id,
        string $firstname,
        string $lastname,
        string $email,
        string $role,
    ): User
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);
            $user->update([
                'first_name' => $firstname,
                'last_name' => $lastname,
                'email' => $email,
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
