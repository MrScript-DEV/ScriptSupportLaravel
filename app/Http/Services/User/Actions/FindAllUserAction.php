<?php

namespace App\Http\Services\User\Actions;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class FindAllUserAction
{
    public function execute(Request $request): Collection
    {
        $query = User::query()->with('roles');

        if ($request->filled('role')) {
            $query->whereHas('roles', function ($q) use ($request) {
                $q->where('name', $request->role);
            });
        }

        return $query->get();
    }
}
