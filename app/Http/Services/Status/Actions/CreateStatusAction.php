<?php

namespace App\Http\Services\Status\Actions;

use App\Models\Status;
use Illuminate\Support\Facades\DB;

class CreateStatusAction
{
    public function execute(
        string $name,
    ): Status
    {
        DB::beginTransaction();

        try {
            $status = new Status([
                'name' => $name,
            ]);

            $status->save();

            DB::commit();

            return $status;

        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
