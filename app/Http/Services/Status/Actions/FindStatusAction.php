<?php

namespace App\Http\Services\Status\Actions;

use App\Models\Status;

class FindStatusAction
{
    public function execute(int $id): Status
    {
        return Status::findOrFail($id);
    }
}
