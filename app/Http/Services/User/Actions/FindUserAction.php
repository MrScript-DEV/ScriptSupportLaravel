<?php

declare(strict_types=1);

namespace App\Http\Services\User\Actions;

use App\Models\User;

class FindUserAction
{
    public function execute(int $id): User
    {
        return User::with('tickets.priority', 'tickets.status', 'tickets.assignedTo')->findOrFail($id);
    }
}
