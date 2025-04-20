<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Api\BaseController;

class LoginController extends BaseController
{
    public function login(Request $request): JsonResponse
    {
        try {
            DB::beginTransaction();

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = Auth::user();
                $success['token'] = $user->createToken('app')->plainTextToken;
                $success['user'] = $user;

                DB::commit();

                return $this->sendResponse(message: __('OK'), result: $success);
            }

            return $this->sendError(error: __('Identifiant invalide'), code: 401);
        } catch (\Exception $e) {
            DB::rollBack();

            if (app()->isLocal()) {
                return $this->sendError(error: __('Une erreur est survenue..'), errorMessages: $e, code: 500);
            }

            return $this->sendError(error: __('Une erreur est survenue..'), code: 500);
        }
    }
}
