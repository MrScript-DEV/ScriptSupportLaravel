<?php

namespace App\Http\Services\User\Actions;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class FindAllUserAction
{
    public function execute(): Collection
    {
        return User::all();
    }
}
