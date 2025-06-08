<?php

declare(strict_types=1);

namespace App\Http\Services\User\Actions;

use App\Models\User;
use App\Models\Message;
use Illuminate\Support\Facades\DB;

class DestroyUserAction
{
    public function execute(int $id): void
    {
        DB::beginTransaction();

        try {
            $user = User::onlyTrashed()->findOrFail($id);

            Message::whereIn('ticket_id', $user->tickets()->withTrashed()->pluck('id'))->withTrashed()->forceDelete();

            $user->tickets()->withTrashed()->forceDelete();

            $user->syncRoles([]);
            $user->syncPermissions([]);

            $user->forceDelete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
