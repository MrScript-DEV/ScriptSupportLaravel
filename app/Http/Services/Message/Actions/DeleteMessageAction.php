<?php

declare(strict_types=1);

namespace App\Http\Services\Message\Actions;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class DeleteMessageAction
{
    public function execute(int $id): void
    {
        DB::beginTransaction();

        try {
            $message = Message::findOrFail($id);
            $message->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
