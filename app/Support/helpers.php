<?php

declare(strict_types=1);

use App\Enums\Role;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

if (!function_exists('authenticatedUser')) {
    function authenticatedUser(): ?User
    {
        return Auth::user();
    }
}

if (!function_exists('isAdmin')) {
    function isAdmin(): bool
    {
        $user = authenticatedUser();
        return $user?->hasRole('Admin') ?? false;
    }
}

if (!function_exists('isSupport')) {
    function isSupport(): bool
    {
        $user = authenticatedUser();
        return $user?->hasRole('Support') ?? false;
    }
}

if (!function_exists('isUser')) {
    function isUser(): bool
    {
        $user = authenticatedUser();
        return $user?->hasRole('User') ?? false;
    }
}


if (!function_exists('isOwner')) {
    function isOwner(int $ownerId): bool
    {
        $user = authenticatedUser();
        return $user && $user->id === $ownerId;
    }
}

if (!function_exists('isTicketOwner')) {
    function isTicketOwner(int $ticketId): bool
    {
        $user = authenticatedUser();

        if (!$user) {
            return false;
        }

        $ticket = Ticket::findOrFail($ticketId);

        if (!$ticket) {
            return false;
        }

        return $ticket->user_id === $user->id;
    }
}

if (!function_exists('isDeleted')) {
    function isDeleted(Model $model): bool
    {
        return method_exists($model, 'trashed') && $model->trashed();
    }
}

if (!function_exists('hasAllPermissions')) {
    function hasAllPermissions(string ...$permissions): bool
    {
        $user = authenticatedUser();
        return $user?->hasAllPermissions($permissions) ?? false;
    }
}

if (!function_exists('hasAnyPermission')) {
    function hasAnyPermission(string ...$permissions): bool
    {
        $user = authenticatedUser();
        return $user?->hasAnyPermission($permissions) ?? false;
    }
}
