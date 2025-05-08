<?php

declare(strict_types=1);

namespace App\Http\Services\Priority\Actions;

use App\Models\Priority;

class FindPriorityAction
{
    public function execute(int $id): Priority
    {
        return Priority::findOrFail($id);
    }
}
