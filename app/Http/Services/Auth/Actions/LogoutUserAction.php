<?php

declare(strict_types=1);

namespace App\Http\Services\Auth\Actions;

use Illuminate\Http\Request;

class LogoutUserAction
{
    public function execute(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
