<?php

declare(strict_types=1);

namespace App\Http\Services\Priority\Actions;

use App\Models\Priority;
use Illuminate\Support\Facades\DB;

class DeletePriorityAction
{
    public function execute(int $id): void
    {
        DB::beginTransaction();

        try {
            $priority = Priority::findOrFail($id);

            $priority->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            throw $e;
        }
    }
}
