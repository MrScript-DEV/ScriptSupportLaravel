<?php

namespace App\Http\Services\Status\Actions;

use App\Models\Status;
use Illuminate\Database\Eloquent\Collection;

class FindAllStatusAction
{
    public function execute(): Collection
    {
        return Status::all();
    }
}
