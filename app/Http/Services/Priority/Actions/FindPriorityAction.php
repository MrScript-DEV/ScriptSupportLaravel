<?php

namespace App\Http\Services\Priority\Actions;

use App\Models\Priority;

class FindPriorityAction
{
    public function execute(int $id): Priority
    {
        return Priority::findOrFail($id);
    }
}
