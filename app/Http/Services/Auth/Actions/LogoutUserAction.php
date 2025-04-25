<?php

namespace App\Http\Services\Auth\Actions;

use Illuminate\Http\Request;

class LogoutUserAction
{
    public function execute(Request $request): void
    {
        $request->user()->currentAccessToken()->delete();
    }
}
