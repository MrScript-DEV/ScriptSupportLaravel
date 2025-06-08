<?php

declare(strict_types=1);

namespace App\Http\Services\Priority\Actions;

use App\Models\Priority;
use Illuminate\Support\Facades\DB;

class CreatePriorityAction
{
    public function execute(
        string $name,
        int $level,
    ): Priority {
        DB::beginTransaction();

        try {
            $priority = new Priority([
                'name' => $name,
                'level' => $level,
            ]);

            $priority->save();

            DB::commit();

            return $priority;
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
