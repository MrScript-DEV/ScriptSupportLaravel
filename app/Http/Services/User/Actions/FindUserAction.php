<?php

namespace App\Http\Services\User\Actions;

use App\Models\User;

class FindUserAction
{
    public function execute(int $id): User
    {
        return User::findOrFail($id);
    }
}
