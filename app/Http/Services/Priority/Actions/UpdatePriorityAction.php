<?php

declare(strict_types=1);

namespace App\Http\Services\Priority\Actions;

use App\Models\Priority;
use Illuminate\Support\Facades\DB;

class UpdatePriorityAction
{
    public function execute(
        int $id,
        string $name,
        int $level,
    ): Priority {
        DB::beginTransaction();

        try {
            $priority = Priority::findOrFail($id);

            $priority->update([
                'name' => $name,
                'level' => $level,
            ]);

            DB::commit();

            return $priority;
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
