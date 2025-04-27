<?php

namespace App\Http\Services\Priority\Actions;

use App\Models\Priority;
use Illuminate\Database\Eloquent\Collection;

class FindAllPriorityAction
{
    public function execute(): Collection
    {
        return Priority::orderBy('level', 'desc')->get();
    }
}
