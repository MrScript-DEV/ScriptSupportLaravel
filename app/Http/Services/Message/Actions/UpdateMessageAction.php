<?php

namespace App\Http\Services\Message\Actions;

use App\Models\Message;
use Illuminate\Support\Facades\DB;

class UpdateMessageAction
{
    public function execute(
        int $id,
        string $messageContent,
    ): Message
    {
        DB::beginTransaction();

        try {
            $message = Message::findOrFail($id);

            $message->update([
                'content' => $messageContent,
            ]);

            DB::commit();

            return $message;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
