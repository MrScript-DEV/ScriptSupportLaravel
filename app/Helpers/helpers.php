<?php

declare(strict_types=1);

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

if (! function_exists('authenticatedUser')) {
    function authenticatedUser(): User
    {
        return Auth::user();
    }
}

if (! function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        $user = authenticatedUser();

        if ($user && $user->role->value === Role::ADMIN->value) {
            return true;
        }

        return false;
    }
}

if (! function_exists('isSupport')) {
    function isSupport(): bool
    {
        $user = authenticatedUser();

        if ($user && $user->role->value === Role::ADMIN->value) {
            return true;
        }

        return false;
    }
}

if (! function_exists('isOwner')) {
    function isOwner(int $id): bool
    {
        $user = authenticatedUser();

        if ($user && $user->id === $id) {
            return true;
        }

        return false;
    }
}

if (! function_exists('isDeleted')) {
    function isDeleted(Model $model): bool
    {
        return method_exists($model, 'trashed') && $model->trashed();
    }
}
