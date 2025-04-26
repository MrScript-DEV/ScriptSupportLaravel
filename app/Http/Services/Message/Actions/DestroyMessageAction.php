<?php

namespace App\Http\Services\Message\Actions;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class DestroyMessageAction
{
    public function execute(int $id): void
    {
        DB::beginTransaction();

        try {
            $message = Message::onlyTrashed()->findOrFail($id);

            $message->forceDelete();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
