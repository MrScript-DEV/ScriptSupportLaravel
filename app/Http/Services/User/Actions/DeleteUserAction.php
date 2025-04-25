<?php

namespace App\Http\Services\User\Actions;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class DeleteUserAction
{
    public function execute(int $id): void
    {
        DB::beginTransaction();

        try {
            $user = User::findOrFail($id);

            foreach ($user->tickets as $ticket) {
                $ticket->messages()->delete();
            }

            $user->tickets()->delete();

            $user->delete();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
